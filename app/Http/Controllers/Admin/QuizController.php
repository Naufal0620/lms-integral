<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function create(Request $request)
    {
        $topicId = $request->query('topic_id');
        $lessonId = $request->query('lesson_id');
        $topics = Topic::all();
        return view('admin.quizzes.create', compact('topics', 'topicId', 'lessonId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'nullable|exists:topics,id',
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz = Quiz::create($validated);

        $redirectRoute = $quiz->lesson_id ? route('admin.topics.show', $quiz->lesson->topic_id) : ($quiz->topic_id ? route('admin.topics.show', $quiz->topic_id) : route('admin.topics.index'));

        return redirect($redirectRoute)->with('success', 'Evaluasi berhasil ditambahkan!');
    }

    public function edit(Quiz $quiz)
    {
        $topics = Topic::all();
        return view('admin.quizzes.edit', compact('quiz', 'topics'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'topic_id' => 'nullable|exists:topics,id',
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz->update($validated);

        $redirectRoute = $quiz->lesson_id ? route('admin.topics.show', $quiz->lesson->topic_id) : ($quiz->topic_id ? route('admin.topics.show', $quiz->topic_id) : route('admin.topics.index'));

        return redirect($redirectRoute)->with('success', 'Evaluasi berhasil diperbarui!');
    }

    public function destroy(Quiz $quiz)
    {
        $redirectRoute = $quiz->lesson_id ? route('admin.topics.show', $quiz->lesson->topic_id) : ($quiz->topic_id ? route('admin.topics.show', $quiz->topic_id) : route('admin.topics.index'));
        $quiz->delete();
        return redirect($redirectRoute)->with('success', 'Evaluasi berhasil dihapus!');
    }
}
