<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\UserQuizAttempt;
use App\Services\GamificationService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.options', 'topic', 'lesson']);
        
        // Check access
        if ($quiz->topic && auth()->user()->level < $quiz->topic->required_level) {
            return redirect()->route('dashboard')->with('error', 'Level Anda belum mencukupi!');
        }

        if ($quiz->lesson && auth()->user()->level < $quiz->lesson->topic->required_level) {
            return redirect()->route('dashboard')->with('error', 'Level Anda belum mencukupi!');
        }

        return view('quizzes.show', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz, GamificationService $gamification)
    {
        $quiz->load(['questions.options', 'lesson']);
        $answers = $request->input('answers', []);
        
        $totalQuestions = $quiz->questions->count();
        if ($totalQuestions === 0) return back()->with('error', 'Kuis ini tidak memiliki pertanyaan.');

        $correctAnswers = 0;
        foreach ($quiz->questions as $question) {
            $selectedOptionId = $answers[$question->id] ?? null;
            $correctOption = $question->options->where('is_correct', true)->first();
            if ($selectedOptionId == ($correctOption->id ?? null)) $correctAnswers++;
        }

        $score = ($correctAnswers / $totalQuestions) * 100;
        $passed = $score >= $quiz->passing_score;

        UserQuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'passed' => $passed
        ]);

        if ($passed) {
            $xpReward = $quiz->lesson ? $quiz->lesson->xp_reward : 50;
            $coinReward = $quiz->lesson ? 10 : 20;
            
            $gamification->addXp(auth()->user(), $xpReward);
            $gamification->addCoins(auth()->user(), $coinReward);
            
            // Auto-complete lesson if this is a lesson quiz
            if ($quiz->lesson_id) {
                \App\Models\UserLessonProgress::firstOrCreate([
                    'user_id' => auth()->id(),
                    'lesson_id' => $quiz->lesson_id,
                ], ['completed_at' => now()]);
            }
            
            $message = "Selamat! Anda lulus " . ($quiz->lesson_id ? 'Evaluasi Materi' : 'Evaluasi Akhir') . " dengan skor " . round($score) . "%. +{$xpReward} XP didapatkan!";
        } else {
            $message = "Skor Anda " . round($score) . "%. Anda belum lulus. Silakan pelajari kembali materinya!";
        }

        return view('quizzes.result', [
            'quiz' => $quiz,
            'score' => $score,
            'passed' => $passed,
            'message' => $message,
            'topic_id' => $quiz->lesson_id ? $quiz->lesson->topic_id : $quiz->topic_id
        ]);
    }
}
