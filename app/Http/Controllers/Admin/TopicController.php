<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::orderBy('order')->get();
        return view('admin.topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        $topic->load(['lessons', 'quizzes']);
        return view('admin.topics.manage', compact('topic'));
    }

    public function create()
    {
        return view('admin.topics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'required_level' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        Topic::create($validated);

        return redirect()->route('admin.topics.index')->with('success', 'Topik berhasil dibuat!');
    }

    public function edit(Topic $topic)
    {
        return view('admin.topics.edit', compact('topic'));
    }

    public function update(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'required_level' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $topic->update($validated);

        return redirect()->route('admin.topics.index')->with('success', 'Topik berhasil diperbarui!');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('admin.topics.index')->with('success', 'Topik berhasil dihapus!');
    }
}
