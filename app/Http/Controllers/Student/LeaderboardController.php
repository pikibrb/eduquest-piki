<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Quiz;

class LeaderboardController extends Controller
{
    public function index()
    {
        
       
        $leaders = Answer::with(['user', 'quiz'])
            ->orderByDesc('score')
            ->take(10)
            ->get();

        return view('leaderboard.index', compact('leaders'));
    
    }

     public function quiz(Quiz $quiz)
    {
        $leaders = Answer::with('user')
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('score')
            ->take(10)
            ->get();

        return view('leaderboard.quiz', compact('quiz', 'leaders'));
    }
}
