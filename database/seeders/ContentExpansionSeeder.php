<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class ContentExpansionSeeder extends Seeder
{
    public function run(): void
    {
        // Get all topics
        $topics = Topic::orderBy('order')->get();

        if ($topics->count() < 6) {
            return;
        }

        // 1. Dasar-Dasar Integral (Topic 1)
        $t1 = $topics[0];
        Lesson::create([
            'topic_id' => $t1->id,
            'title' => 'Integrasi Fungsi Pangkat Sederhana',
            'content' => 'Aturan pangkat adalah aturan dasar yang paling sering digunakan dalam kalkulus integral.' . "\n\n" . 'Rumus Umum:' . "\n" . '$$\int x^n dx = \frac{x^{n+1}}{n+1} + C, \quad n \neq -1$$' . "\n\n" . 'Contoh:' . "\n" . '$$\int x^4 dx = \frac{x^5}{5} + C$$' . "\n" . '$$\int \sqrt{x} dx = \int x^{1/2} dx = \frac{x^{3/2}}{3/2} + C = \frac{2}{3}x\sqrt{x} + C$$',
            'order' => 3,
            'xp_reward' => 30,
        ]);

        // 2. Integral Tentu (Topic 2)
        $t2 = $topics[1];
        Lesson::create([
            'topic_id' => $t2->id,
            'title' => 'Sifat-Sifat Integral Tentu',
            'content' => 'Integral tentu memiliki beberapa sifat penting yang memudahkan perhitungan:' . "\n\n" . '1. Batas yang sama:' . "\n" . '$$\int_{a}^{a} f(x) dx = 0$$' . "\n\n" . '2. Batas terbalik:' . "\n" . '$$\int_{a}^{b} f(x) dx = -\int_{b}^{a} f(x) dx$$' . "\n\n" . '3. Penjumlahan Interval:' . "\n" . '$$\int_{a}^{c} f(x) dx = \int_{a}^{b} f(x) dx + \int_{b}^{c} f(x) dx$$',
            'order' => 2,
            'xp_reward' => 45,
        ]);

        // 3. Teknik Integrasi Substitusi (Topic 3)
        $t3 = $topics[2];
        Lesson::create([
            'topic_id' => $t3->id,
            'title' => 'Substitusi pada Integral Tentu',
            'content' => 'Saat menggunakan substitusi pada integral tentu, kita memiliki dua pilihan: mengembalikan variabel ke \(x\) atau mengubah batas integrasinya.' . "\n\n" . 'Metode Ubah Batas:' . "\n" . 'Jika \(u = g(x)\), maka:' . "\n" . '$$\int_{a}^{b} f(g(x))g\'(x) dx = \int_{g(a)}^{g(b)} f(u) du$$' . "\n\n" . 'Cara ini seringkali lebih cepat karena kita tidak perlu melakukan substitusi balik di akhir perhitungan.',
            'order' => 2,
            'xp_reward' => 65,
        ]);

        // 4. Integral Fungsi Trigonometri (Topic 4)
        $t4 = $topics[3];
        Lesson::create([
            'topic_id' => $t4->id,
            'title' => 'Identitas Trigonometri dalam Integral',
            'content' => 'Seringkali kita perlu mengubah bentuk fungsi trigonometri menggunakan identitas sebelum mengintegralkannya.' . "\n\n" . 'Identitas Penting:' . "\n" . '1. \(\sin^2 x + \cos^2 x = 1\)' . "\n" . '2. \(\sin^2 x = \frac{1 - \cos 2x}{2}\)' . "\n" . '3. \(\cos^2 x = \frac{1 + \cos 2x}{2}\)' . "\n\n" . 'Contoh penggunaan untuk \(\int \sin^2 x dx\):' . "\n" . '$$\int \frac{1 - \cos 2x}{2} dx = \frac{1}{2}x - \frac{1}{4}\sin 2x + C$$',
            'order' => 2,
            'xp_reward' => 55,
        ]);

        // 5. Aplikasi Integral: Luas Daerah (Topic 5)
        $t5 = $topics[4];
        Lesson::create([
            'topic_id' => $t5->id,
            'title' => 'Luas di Antara Dua Kurva',
            'content' => 'Jika kita memiliki dua kurva \(y = f(x)\) (atas) dan \(y = g(x)\) (bawah), luas daerah di antara keduanya adalah:' . "\n\n" . '$$L = \int_{a}^{b} [f(x) - g(x)] dx$$' . "\n\n" . 'Langkah penyelesaian:' . "\n" . '1. Cari titik potong kedua kurva untuk menentukan batas \(a\) dan \(b\).' . "\n" . '2. Tentukan kurva mana yang berada di atas pada interval tersebut.' . "\n" . '3. Lakukan pengintegralan selisih fungsi.',
            'order' => 2,
            'xp_reward' => 75,
        ]);

        // 6. Teknik Integrasi Parsial (Topic 6)
        $t6 = $topics[5];
        Lesson::create([
            'topic_id' => $t6->id,
            'title' => 'Metode Tabulasi (Metode DI)',
            'content' => 'Untuk integral parsial yang dilakukan berulang kali (seperti \(x^n\) dikalikan \(\sin x\) atau \(e^x\)), Metode DI sangat efisien.' . "\n\n" . 'Cara Kerja:' . "\n" . '1. Buat dua kolom: <b>D</b> (turunan) dan <b>I</b> (integral).' . "\n" . '2. Pilih fungsi yang akan diturunkan sampai nol di kolom D.' . "\n" . '3. Pilih fungsi yang akan diintegralkan di kolom I.' . "\n" . '4. Berikan tanda selang-seling (+, -, +, ...).' . "\n\n" . 'Hasil didapat dari perkalian diagonal.',
            'order' => 2,
            'xp_reward' => 85,
        ]);
    }
}
