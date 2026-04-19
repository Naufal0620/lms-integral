<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonSlide;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;

class LessonSlideSeeder extends Seeder
{
    public function run(): void
    {
        $lesson = Lesson::first();
        if (!$lesson) return;

        // Slide 1: Teori
        $s1 = LessonSlide::create([
            'lesson_id' => $lesson->id,
            'title' => 'Pendahuluan Integral',
            'content' => 'Integral adalah konsep penting dalam kalkulus yang sering disebut sebagai antiturunan.' . "\n\n" . 'Secara sederhana, jika turunan mencari kemiringan kurva, maka integral mencari luas di bawah kurva tersebut.',
            'type' => 'content',
            'order' => 1,
        ]);

        // Slide 2: Rumus
        $s2 = LessonSlide::create([
            'lesson_id' => $lesson->id,
            'title' => 'Rumus Dasar',
            'content' => 'Rumus dasar integral tak tentu untuk fungsi pangkat adalah:' . "\n\n" . '$$\int x^n dx = \frac{1}{n+1} x^{n+1} + C$$' . "\n\n" . 'Jangan lupa menambahkan \(C\) sebagai konstanta integrasi!',
            'type' => 'content',
            'order' => 2,
        ]);

        // Slide 3: Kuis Cepat
        $s3 = LessonSlide::create([
            'lesson_id' => $lesson->id,
            'type' => 'quiz',
            'order' => 3,
        ]);

        $q = Question::create([
            'lesson_slide_id' => $s3->id,
            'question_text' => 'Berapakah hasil dari \(\int x^2 dx\)?',
            'points' => 10,
        ]);

        Option::create(['question_id' => $q->id, 'option_text' => '\(\frac{1}{3}x^3 + C\)', 'is_correct' => true]);
        Option::create(['question_id' => $q->id, 'option_text' => '\(2x + C\)', 'is_correct' => false]);
        Option::create(['question_id' => $q->id, 'option_text' => '\(x^3 + C\)', 'is_correct' => false]);
    }
}
