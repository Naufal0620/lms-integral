<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\TopicController as AdminTopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TopicController::class, 'index'])->name('dashboard');
    
    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');
    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('topics', AdminTopicController::class);
    Route::resource('lessons', \App\Http\Controllers\Admin\LessonController::class);
    Route::resource('lessons.slides', \App\Http\Controllers\Admin\LessonSlideController::class);
    Route::resource('quizzes', \App\Http\Controllers\Admin\QuizController::class);
    Route::get('quizzes/{quiz}/questions', [\App\Http\Controllers\Admin\QuestionController::class, 'index'])->name('quizzes.questions.index');
    Route::post('quizzes/{quiz}/questions', [\App\Http\Controllers\Admin\QuestionController::class, 'store'])->name('quizzes.questions.store');
    Route::delete('questions/{question}', [\App\Http\Controllers\Admin\QuestionController::class, 'destroy'])->name('questions.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
