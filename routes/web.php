<?php

use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Admin\AnswerController as AdminAnswerController;
use App\Http\Controllers\Student\LeaderboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('quizzes', AdminQuizController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/quizzes/{quiz}/answers', [AdminAnswerController::class, 'index'])->name('admin.answers.index');
    Route::get('/quizzes/{quiz}/answers/{user}', [AdminAnswerController::class, 'show'])->name('admin.answers.show');
});


//siswa
Route::middleware('student')->prefix('student')->name('student.')->group(function () {
    Route::get('quizzes', [StudentQuizController::class, 'index'])->name('quizzes.index');
    Route::get('quizzes/{quiz}', [StudentQuizController::class, 'start'])->name('quizzes.start');
    Route::post('quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('result/{quiz}', [StudentQuizController::class, 'result'])->name('quizzes.result');
});
//lb global
Route::middleware(['auth'])->group(function () {
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
});

 //lb per kuis
    Route::get('/leaderboard/quiz/{quiz}', [LeaderboardController::class, 'quiz'])->name('leaderboard.quiz');

require __DIR__ . '/auth.php';
