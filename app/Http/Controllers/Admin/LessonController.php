<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function create(Request $request)
    {
        $topicId = $request->query('topic_id');
        $topics = Topic::all();
        return view('admin.lessons.create', compact('topics', 'topicId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
            'xp_reward' => 'required|integer',
        ]);

        $validated['content'] = ''; // Legacy field

        $lesson = Lesson::create($validated);

        // Auto-create first slide
        $lesson->slides()->create([
            'title' => 'Halaman Pertama',
            'content' => [
                'time' => time(),
                'blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Materi: ' . $lesson->title, 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Tulis konten materi Anda di sini menggunakan editor blok.']]
                ],
                'version' => '2.28.2'
            ],
            'type' => 'content',
            'order' => 1,
        ]);

        return redirect()->route('admin.topics.show', $lesson->topic_id)->with('success', 'Materi berhasil ditambahkan!');
    }

    public function edit(Lesson $lesson)
    {
        $topics = Topic::all();
        return view('admin.lessons.edit', compact('lesson', 'topics'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
            'xp_reward' => 'required|integer',
        ]);

        $lesson->update($validated);

        return redirect()->route('admin.topics.show', $lesson->topic_id)->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy(Lesson $lesson)
    {
        $topicId = $lesson->topic_id;
        $lesson->delete();
        return redirect()->route('admin.topics.show', $topicId)->with('success', 'Materi berhasil dihapus!');
    }
}
