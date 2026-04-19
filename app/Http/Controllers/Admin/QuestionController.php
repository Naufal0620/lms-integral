<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $quiz->load('questions.options');
        return view('admin.questions.index', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'points' => 'required|integer|min:0',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text'],
            'points' => $validated['points'],
        ]);

        foreach ($validated['options'] as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => $index == $validated['correct_option'],
            ]);
        }

        return back()->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
