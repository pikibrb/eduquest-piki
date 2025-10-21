<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\UserAnswer;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->get();

        $doneQuizIds = [];
        if (Auth::check()) {
            $doneQuizIds = Answer::where('user_id', Auth::id())
                ->pluck('quiz_id')
                ->toArray();
        }
        return view('student.quizzes.index', compact('quizzes', 'doneQuizIds'));
    }

    public function start($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $userId = Auth::id();

        // Jika sudah mengerjakan -> redirect ke result
        $existing = Answer::where('user_id', $userId)
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($existing) {
            return redirect()->route('student.quizzes.result', ['quiz' => $quiz->id])
                ->with('info', 'Anda sudah mengerjakan kuis ini. Menampilkan hasil.');
        }

        return view('student.quizzes.start', compact('quiz'));
    }

    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $user = Auth::user();

        // cek ulang — bila sudah ada record, jangan terima submission lagi
        $existing = Answer::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($existing) {
            return redirect()->route('student.quizzes.result', ['quiz' => $quiz->id])
                ->with('warning', 'Submission diblokir: Anda sudah mengerjakan kuis ini.');
        }

        $answersInput = $request->input('answers', []);
        $correct = 0;
        $total = $quiz->questions->count();

        // hapus jawaban lama (sebagai safety — biasanya tidak ada karena cek di atas)
        UserAnswer::where('user_id', $user->id)->where('quiz_id', $quiz->id)->delete();

        foreach ($quiz->questions as $question) {
            $selected = $answersInput[$question->id] ?? null;
            $isCorrect = $selected && strtolower($selected) === strtolower($question->correct_option);

            if ($isCorrect) $correct++;

            UserAnswer::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'question_id' => $question->id,
                'selected_option' => $selected,
                'is_correct' => (bool) $isCorrect,
            ]);
        }

        $score = $total > 0 ? round(($correct / $total) * 100) : 0;

        // simpan nilai akhir (create, bukan update) — karena kita blok ulangan
        Answer::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
        ]);

        return redirect()->route('student.quizzes.result', ['quiz' => $quiz->id])
            ->with('success', 'Kuis berhasil dikirim. Nilai tersimpan.');
    }

    public function result($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);

        $result = Answer::where('quiz_id', $quiz->id)
            ->where('user_id', Auth::id())
            ->first();

        if (! $result) {
            return redirect()->route('student.quizzes.index')
                ->with('warning', 'Hasil kuis belum ditemukan. Silakan kerjakan kuis terlebih dahulu.');
        }

        $userAnswers = UserAnswer::with('question')
            ->where('quiz_id', $quiz->id)
            ->where('user_id', Auth::id())
            ->get();

        return view('student.quizzes.result', compact('quiz', 'result', 'userAnswers'));
    }
}
