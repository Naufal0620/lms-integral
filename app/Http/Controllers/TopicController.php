<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::where('is_active', true)
            ->with(['lessons', 'quizzes'])
            ->orderBy('order')
            ->get();
            
        return view('dashboard', compact('topics'));
    }

    public function show(Topic $topic)
    {
        if (auth()->user()->level < $topic->required_level) {
            return back()->with('error', "Anda perlu mencapai level {$topic->required_level} untuk membuka topik ini!");
        }

        $topic->load('lessons', 'quizzes');
        
        return view('topics.show', compact('topic'));
    }
}
