<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonSlide;
use Illuminate\Database\Seeder;

class ExampleSlideSeeder extends Seeder
{
    public function run(): void
    {
        $lesson = Lesson::where('order', 1)->first();

        if ($lesson) {
            LessonSlide::create([
                'lesson_id' => $lesson->id,
                'title' => 'Contoh Gabungan Math & Grafik',
                'content' => [
                    'time' => time(),
                    'blocks' => [
                        [
                            'type' => 'header',
                            'data' => [
                                'text' => 'Analisis Luas Parabola',
                                'level' => 2
                            ]
                        ],
                        [
                            'type' => 'paragraph',
                            'data' => [
                                'text' => 'Luas daerah di bawah kurva \(f(x) = x^2\) pada rentang \([0, 2]\) dapat dihitung dengan rumus integral tentu berikut:'
                            ]
                        ],
                        [
                            'type' => 'math',
                            'data' => [
                                'formula' => '\int_{0}^{2} x^2 \, dx = \left[ \frac{1}{3}x^3 \right]_{0}^{2} = \frac{8}{3}'
                            ]
                        ],
                        [
                            'type' => 'paragraph',
                            'data' => [
                                'text' => 'Perhatikan arsiran biru pada grafik di bawah ini yang merepresentasikan nilai dari perhitungan di atas.'
                            ]
                        ],
                        [
                            'type' => 'visualization',
                            'data' => [
                                'title' => 'Visualisasi Integral Tentu \(f(x) = x^2\)',
                                'boundingbox' => [-1, 5, 3, -1],
                                'elements' => [
                                    ['type' => 'integral', 'formula' => 'x^2', 'start' => 0, 'end' => 2, 'color' => '#3b82f6'],
                                    ['type' => 'function', 'formula' => 'x^2', 'color' => '#1e293b'],
                                ],
                                'footer' => 'Daerah yang diarsir biru merepresentasikan nilai \(\int_{0}^{2} x^2 dx = 8/3 \approx 2.67\).'
                            ]
                        ],
                        [
                            'type' => 'paragraph',
                            'data' => [
                                'text' => 'Dengan menggunakan sistem blok ini, Anda bisa menyisipkan visualisasi di bagian mana saja untuk memperkuat penjelasan teks.'
                            ]
                        ]
                    ],
                    'version' => '2.30.7'
                ],
                'type' => 'content',
                'order' => 99, // Taruh di paling akhir
            ]);
        }
    }
}
