<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonSlide;
use Illuminate\Http\Request;

class LessonSlideController extends Controller
{
    public function index(Lesson $lesson)
    {
        $slides = $lesson->slides()->orderBy('order')->get();
        return view('admin.slides.index', compact('lesson', 'slides'));
    }

    public function create(Lesson $lesson)
    {
        return view('admin.slides.create', compact('lesson'));
    }

    public function store(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required',
            'type' => 'required|in:content,quiz',
            'order' => 'required|integer',
        ]);

        if (is_string($validated['content'])) {
            $validated['content'] = json_decode($validated['content'], true);
        }

        $lesson->slides()->create($validated);

        return redirect()->route('admin.lessons.slides.index', $lesson)->with('success', 'Slide berhasil ditambahkan!');
    }

    public function edit(Lesson $lesson, LessonSlide $slide)
    {
        return view('admin.slides.edit', compact('lesson', $slide->id === null ? 'slide' : 'slide')); // Fix for possible undefined variable if not passed correctly
    }

    public function update(Request $request, Lesson $lesson, LessonSlide $slide)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required',
            'type' => 'required|in:content,quiz',
            'order' => 'required|integer',
        ]);

        if (is_string($validated['content'])) {
            $validated['content'] = json_decode($validated['content'], true);
        }

        $slide->update($validated);

        return redirect()->route('admin.lessons.slides.index', $lesson)->with('success', 'Slide berhasil diperbarui!');
    }

    public function destroy(Lesson $lesson, LessonSlide $slide)
    {
        $slide->delete();
        return redirect()->route('admin.lessons.slides.index', $lesson)->with('success', 'Slide berhasil dihapus!');
    }
}
