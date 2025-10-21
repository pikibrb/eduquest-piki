<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $quiz = Quiz::create($request->only('title', 'description'));

        foreach ($request->questions as $q) {
            Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_option' => $q['correct_option'],
            ]);
        }

        return redirect()->route('admin.quizzes.index')->with('success', 'Kuis berhasil dibuat!');
    }
    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $answers = Answer::where('quiz_id', $quiz->id)->with('user')->get();

        return view('admin.quizzes.show', compact('quiz', 'answers'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return back()->with('success', 'Kuis dihapus.');
    }
}
