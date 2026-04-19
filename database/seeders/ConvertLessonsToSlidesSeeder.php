<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonSlide;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;

class ConvertLessonsToSlidesSeeder extends Seeder
{
    private function toEditorJS($blocks)
    {
        return [
            'time' => time(),
            'blocks' => $blocks,
            'version' => '2.28.2'
        ];
    }

    private function p($text)
    {
        return ['type' => 'paragraph', 'data' => ['text' => $text]];
    }

    private function h($text, $level = 2)
    {
        return ['type' => 'header', 'data' => ['text' => $text, 'level' => $level]];
    }

    private function math($formula)
    {
        return ['type' => 'math', 'data' => ['formula' => $formula]];
    }

    private function viz($title, $elements, $bbox = [-1, 10, 11, -1], $footer = '')
    {
        return [
            'type' => 'visualization', 
            'data' => [
                'title' => $title, 
                'elements' => $elements, 
                'boundingbox' => $bbox,
                'footer' => $footer
            ]
        ];
    }

    public function run(): void
    {
        $lessons = Lesson::all();
        
        foreach ($lessons as $lesson) {
            $lesson->slides()->delete();
            
            // Topic 1 Basics
            if ($lesson->topic->order == 1) {
                if ($lesson->order == 1) {
                    LessonSlide::create([
                        'lesson_id' => $lesson->id,
                        'title' => 'Konsep Dasar',
                        'content' => $this->toEditorJS([
                            $this->h('Apa itu Integral?'),
                            $this->p('Integral tak tentu adalah proses mencari fungsi asal jika kita mengetahui fungsi turunannya.'),
                            $this->p('Dalam kalkulus, kita sering kali perlu "memutar balik" waktu untuk menemukan fungsi posisi dari fungsi kecepatan.'),
                            $this->h('Analogi Sederhana', 3),
                            $this->p('Jika <b>Turunan</b> adalah: "Berapa kemiringan di titik ini?"'),
                            $this->p('Maka <b>Integral</b> adalah: "Fungsi apa yang memiliki kemiringan seperti ini?"'),
                            $this->p('Simbol integral \(\int\) sebenarnya berasal dari huruf "S" yang berarti <b>Sum</b> (Jumlah).'),
                        ]),
                        'type' => 'content', 'order' => 1,
                    ]);
                } 
                elseif ($lesson->order == 2) {
                    LessonSlide::create([
                        'lesson_id' => $lesson->id,
                        'title' => 'Konstanta Integrasi',
                        'content' => $this->toEditorJS([
                            $this->h('Mengapa Harus +C?'),
                            $this->p('Karena ada tak terhingga banyaknya fungsi yang memiliki turunan yang sama. Tanpa informasi tambahan, kita tidak tahu di mana posisi vertikal kurva yang asli.'),
                            $this->viz('Keluarga Kurva \(f(x) = x^2 + C\)', [
                                ['type' => 'function', 'formula' => 'x^2 - 2', 'color' => '#3b82f6'],
                                ['type' => 'function', 'formula' => 'x^2', 'color' => '#10b981'],
                                ['type' => 'function', 'formula' => 'x^2 + 2', 'color' => '#ef4444'],
                                ['type' => 'point', 'x' => 0, 'y' => -2, 'label' => 'C = -2', 'color' => '#3b82f6'],
                                ['type' => 'point', 'x' => 0, 'y' => 0, 'label' => 'C = 0', 'color' => '#10b981'],
                                ['type' => 'point', 'x' => 0, 'y' => 2, 'label' => 'C = 2', 'color' => '#ef4444'],
                            ], [-4, 8, 4, -4], 'Setiap warna mewakili nilai konstanta C yang berbeda.'),
                            $this->p('Semua kurva di atas memiliki kemiringan (turunan) yang identik pada setiap nilai X yang sama.'),
                        ]),
                        'type' => 'content', 'order' => 1,
                    ]);
                }
                elseif ($lesson->order == 3) {
                    LessonSlide::create([
                        'lesson_id' => $lesson->id,
                        'title' => 'Aturan Pangkat',
                        'content' => $this->toEditorJS([
                            $this->h('Rumus Umum'),
                            $this->math('\int x^n dx = \frac{x^{n+1}}{n+1} + C'),
                            $this->p('Langkah-langkah:'),
                            ['type' => 'list', 'data' => ['style' => 'ordered', 'items' => [
                                'Tambahkan pangkat dengan 1.',
                                'Bagi dengan pangkat baru tersebut.',
                                'Tambahkan C.'
                            ]]],
                        ]),
                        'type' => 'content', 'order' => 1,
                    ]);
                }
            }

            // Topic 5 Area
            if ($lesson->topic->order == 5) {
                if ($lesson->order == 1) {
                    LessonSlide::create([
                        'lesson_id' => $lesson->id,
                        'title' => 'Luas Daerah',
                        'content' => $this->toEditorJS([
                            $this->h('Konsep Geometris'),
                            $this->p('Integral tentu merepresentasikan luas daerah di bawah kurva pada interval tertentu.'),
                            $this->viz('Luas di Bawah Kurva \(y = x^2\)', [
                                ['type' => 'integral', 'formula' => 'x^2', 'start' => 0, 'end' => 2, 'color' => '#3b82f6'],
                                ['type' => 'function', 'formula' => 'x^2', 'color' => '#1e293b'],
                            ], [-1, 5, 3, -1], 'Daerah biru menunjukkan nilai dari \(\int_{0}^{2} x^2 dx\).'),
                        ]),
                        'type' => 'content', 'order' => 1,
                    ]);
                } else {
                    LessonSlide::create([
                        'lesson_id' => $lesson->id,
                        'title' => 'Antara Dua Kurva',
                        'content' => $this->toEditorJS([
                            $this->h('Selisih Dua Fungsi'),
                            $this->p('Luas daerah di antara dua kurva dihitung dengan mengurangkan fungsi atas dengan fungsi bawah.'),
                            $this->math('L = \int_{a}^{b} [f(x) - g(x)] dx'),
                            $this->viz('Visualisasi Antara Dua Kurva', [
                                ['type' => 'function', 'formula' => '4-x^2', 'color' => '#ef4444'],
                                ['type' => 'function', 'formula' => 'x^2', 'color' => '#3b82f6'],
                                ['type' => 'integral', 'formula' => '(4-x^2)-(x^2)', 'start' => -1.41, 'end' => 1.41, 'color' => '#10b981'],
                            ], [-3, 6, 3, -1], 'Daerah hijau adalah luas antara \(f(x) = 4-x^2\) dan \(g(x) = x^2\).'),
                        ]),
                        'type' => 'content', 'order' => 1,
                    ]);
                }
            }
            
            // Default fallback for other content
            if ($lesson->slides()->count() == 0) {
                $lessonBlocks = [];
                $paragraphs = explode("\n\n", $lesson->content);
                foreach ($paragraphs as $p) {
                    if (trim($p)) $lessonBlocks[] = $this->p(trim($p));
                }
                
                LessonSlide::create([
                    'lesson_id' => $lesson->id,
                    'title' => $lesson->title,
                    'content' => $this->toEditorJS($lessonBlocks),
                    'type' => 'content',
                    'order' => 1,
                ]);
            }
            
            // Create evaluation
            Quiz::updateOrCreate(['lesson_id' => $lesson->id], [
                'title' => 'Evaluasi: ' . $lesson->title,
                'description' => 'Uji pemahaman materi ' . $lesson->title,
                'passing_score' => 80,
            ]);
        }
    }
}
