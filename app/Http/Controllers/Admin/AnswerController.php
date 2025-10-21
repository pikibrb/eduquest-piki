<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\UserAnswer;
use App\Models\User;

class AnswerController extends Controller
{
    public function index($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $answers = Answer::with('user')
            ->where('quiz_id', $quizId)
            ->get();

        return view('admin.answers.index', compact('quiz', 'answers'));
    }

    public function show($quizId, $userId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $user = User::findOrFail($userId);
        $userAnswers = UserAnswer::with('question')
            ->where('quiz_id', $quizId)
            ->where('user_id', $userId)
            ->get();

        $result = Answer::where('quiz_id', $quizId)
            ->where('user_id', $userId)
            ->first();

        return view('admin.answers.show', compact('quiz', 'user', 'userAnswers', 'result'));
    }
}
