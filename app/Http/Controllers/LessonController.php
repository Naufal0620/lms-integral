<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\UserLessonProgress;
use App\Services\GamificationService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show(Lesson $lesson)
    {
        $lesson->load(['topic', 'slides.questions.options']);
        
        $completed = UserLessonProgress::where('user_id', auth()->id())
            ->where('lesson_id', $lesson->id)
            ->exists();
            
        return view('lessons.show', compact('lesson', 'completed'));
    }

    public function complete(Lesson $lesson, GamificationService $gamification)
    {
        $userId = auth()->id();
        
        $progress = UserLessonProgress::firstOrCreate([
            'user_id' => $userId,
            'lesson_id' => $lesson->id,
        ]);
        
        if (!$progress->completed_at) {
            $progress->completed_at = now();
            $progress->save();
            
            $gamification->addXp(auth()->user(), $lesson->xp_reward);
            
            return redirect()->route('topics.show', $lesson->topic_id)
                ->with('status', "Pelajaran selesai! +{$lesson->xp_reward} XP didapatkan!");
        }
        
        return redirect()->route('topics.show', $lesson->topic_id);
    }
}
