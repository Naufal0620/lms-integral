<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        User::create(['name' => 'Administrator', 'email' => 'admin@integral.com', 'password' => Hash::make('password'), 'role' => 'admin', 'level' => 1, 'xp' => 0, 'coins' => 0]);
        
        $students = [
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@mahasiswa.ac.id'],
            ['name' => 'Said M. Naufal', 'email' => 'said@mahasiswa.ac.id'],
            ['name' => 'Rizky Pratama', 'email' => 'rizky@mahasiswa.ac.id'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@mahasiswa.ac.id'],
            ['name' => 'Bambang Pamungkas', 'email' => 'bambang@mahasiswa.ac.id'],
        ];

        foreach ($students as $student) {
            User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'level' => 1,
                'xp' => rand(0, 500), // Memberikan sedikit variasi XP awal untuk leaderboard
                'coins' => 0
            ]);
        }

        // 2. BAB 1: DASAR-DASAR INTEGRAL (DETAILED)
        $w1 = Topic::create([
            'title' => 'Dasar-Dasar Integral',
            'description' => 'Mempelajari konsep antiturunan, notasi integral, dan aturan pangkat dasar untuk fungsi aljabar.',
            'order' => 1, 'required_level' => 1,
        ]);

        // Materi 1.1: Konsep Antiturunan
        $l1 = Lesson::create(['topic_id' => $w1->id, 'title' => 'Konsep Antiturunan & Notasi', 'order' => 1, 'xp_reward' => 30, 'content' => '']);
        $l1->slides()->createMany([
            ['title' => 'Definisi Antiturunan', 'type' => 'content', 'order' => 1, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Apa itu Antiturunan?', 'level' => 2]],
                ['type' => 'paragraph', 'data' => ['text' => 'Integral tak tentu adalah proses menentukan fungsi asal jika turunannya diketahui. Inilah mengapa ia disebut <b>Antiturunan</b>.']],
                ['type' => 'math', 'data' => ['formula' => 'F\'(x) = f(x) \implies \int f(x) dx = F(x) + C']]
            ]]],
            ['title' => 'Notasi Leibniz', 'type' => 'content', 'order' => 2, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Mengenal Simbol Integral', 'level' => 2]],
                ['type' => 'paragraph', 'data' => ['text' => 'Simbol \(\int\) pertama kali digunakan oleh Gottfried Leibniz. Komponennya adalah:']],
                ['type' => 'paragraph', 'data' => ['text' => '1. \(\int\) : Operator Integrasi<br>2. \(f(x)\) : Integran (fungsi yang diproses)<br>3. \(dx\) : Diferensial (menandakan variabel integrasi)']]
            ]]],
            ['title' => 'Konstanta Integrasi', 'type' => 'content', 'order' => 3, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Mengapa Ada +C?', 'level' => 3]],
                ['type' => 'paragraph', 'data' => ['text' => 'Turunan dari \(x^2 + 5\), \(x^2 - 10\), dan \(x^2 + \pi\) semuanya adalah \(2x\).']],
                ['type' => 'paragraph', 'data' => ['text' => 'Saat kita melakukan integral balik dari \(2x\), kita tidak tahu angka konstanta apa yang ada di sana sebelumnya. Maka kita gunakan \(C\).']]
            ]]]
        ]);
        $q1 = Quiz::create(['lesson_id' => $l1->id, 'title' => 'Kuis Dasar & Notasi', 'description' => 'Evaluasi materi antiturunan', 'passing_score' => 80]);
        $q1_1 = Question::create(['quiz_id' => $q1->id, 'question_text' => 'Jika turunan fungsi asal adalah f(x), maka integral f(x) disebut...', 'points' => 100]);
        Option::create(['question_id' => $q1_1->id, 'option_text' => 'Antiturunan', 'is_correct' => true]);
        Option::create(['question_id' => $q1_1->id, 'option_text' => 'Diferensial Kedua', 'is_correct' => false]);

        // Materi 1.2: Aturan Pangkat
        $l2 = Lesson::create(['topic_id' => $w1->id, 'title' => 'Aturan Pangkat Dasar', 'order' => 2, 'xp_reward' => 40, 'content' => '']);
        $l2->slides()->createMany([
            ['title' => 'Rumus Umum', 'type' => 'content', 'order' => 1, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Aturan Pangkat Aljabar', 'level' => 2]],
                ['type' => 'math', 'data' => ['formula' => '\int x^n dx = \frac{1}{n+1} x^{n+1} + C']],
                ['type' => 'paragraph', 'data' => ['text' => 'Aturan ini berlaku selama \(n \neq -1\).']]
            ]]],
            ['title' => 'Contoh Polinomial', 'type' => 'content', 'order' => 2, 'content' => ['blocks' => [
                ['type' => 'paragraph', 'data' => ['text' => 'Contoh: \(\int x^5 dx\).']],
                ['type' => 'paragraph', 'data' => ['text' => 'Langkah:<br>1. Tambahkan pangkat: \(5+1 = 6\)<br>2. Bagi dengan pangkat baru: \(\frac{1}{6}\)<br>3. Hasil: \(\frac{1}{6}x^6 + C\)']]
            ]]]
        ]);
        $q2 = Quiz::create(['lesson_id' => $l2->id, 'title' => 'Kuis Aturan Pangkat', 'description' => 'Hitung integral pangkat', 'passing_score' => 80]);
        $q2_1 = Question::create(['quiz_id' => $q2->id, 'question_text' => 'Berapakah hasil dari \(\int x^3 dx\)?', 'points' => 100]);
        Option::create(['question_id' => $q2_1->id, 'option_text' => '1/4 x^4 + C', 'is_correct' => true]);
        Option::create(['question_id' => $q2_1->id, 'option_text' => '3x^2 + C', 'is_correct' => false]);

        // Materi 1.3: Integrasi Fungsi Pangkat Sederhana (Moved from ContentExpansion)
        $l1_3 = Lesson::create(['topic_id' => $w1->id, 'title' => 'Integrasi Fungsi Pangkat Sederhana', 'order' => 3, 'xp_reward' => 30, 'content' => '']);
        $l1_3->slides()->createMany([
            ['title' => 'Akar & Pangkat Negatif', 'type' => 'content', 'order' => 1, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Bentuk Akar dan Pecahan', 'level' => 2]],
                ['type' => 'paragraph', 'data' => ['text' => 'Ubah bentuk akar atau pecahan menjadi pangkat sebelum diintegralkan.']],
                ['type' => 'math', 'data' => ['formula' => '\int \sqrt{x} dx = \int x^{1/2} dx = \frac{2}{3}x^{3/2} + C']],
                ['type' => 'math', 'data' => ['formula' => '\int \frac{1}{x^2} dx = \int x^{-2} dx = -x^{-1} + C = -\frac{1}{x} + C']]
            ]]]
        ]);
        $q1_3 = Quiz::create(['lesson_id' => $l1_3->id, 'title' => 'Kuis Pangkat Variasi', 'description' => 'Integral akar dan pecahan', 'passing_score' => 80]);
        $q1_3_1 = Question::create(['quiz_id' => $q1_3->id, 'question_text' => 'Berapakah hasil dari \(\int x^{-3} dx\)?', 'points' => 100]);
        Option::create(['question_id' => $q1_3_1->id, 'option_text' => '-1/2 x^-2 + C', 'is_correct' => true]);
        Option::create(['question_id' => $q1_3_1->id, 'option_text' => '-1/4 x^-4 + C', 'is_correct' => false]);

        // Evaluasi Akhir Bab 1
        $qf1 = Quiz::create(['topic_id' => $w1->id, 'title' => 'Evaluasi Akhir: Dasar Integral', 'description' => 'Ujian kelulusan Bab 1', 'passing_score' => 75]);
        $qf1_1 = Question::create(['quiz_id' => $qf1->id, 'question_text' => 'Selesaikan integral dari \(\int (2x + 1) dx\).', 'points' => 100]);
        Option::create(['question_id' => $qf1_1->id, 'option_text' => 'x^2 + x + C', 'is_correct' => true]);
        Option::create(['question_id' => $qf1_1->id, 'option_text' => '2x^2 + x + C', 'is_correct' => false]);


        // 3. BAB 2: INTEGRAL TENTU
        $w2 = Topic::create(['title' => 'Integral Tentu', 'description' => 'Penerapan integral pada interval tertutup untuk menghitung akumulasi dan nilai eksak.', 'order' => 2, 'required_level' => 1]);

        // Materi 2.1: Definisi & Batas Integrasi
        $l2_1 = Lesson::create(['topic_id' => $w2->id, 'title' => 'Definisi & Batas Integrasi', 'order' => 1, 'xp_reward' => 35, 'content' => '']);
        $l2_1->slides()->createMany([
            ['title' => 'Konsep Akumulasi', 'type' => 'content', 'order' => 1, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Integral sebagai Akumulasi', 'level' => 2]],
                ['type' => 'paragraph', 'data' => ['text' => 'Berbeda dengan integral tak tentu yang menghasilkan fungsi, integral tentu menghasilkan sebuah <b>angka/nilai eksak</b>.']],
                ['type' => 'paragraph', 'data' => ['text' => 'Ia mewakili akumulasi total nilai fungsi pada interval tertentu, yang secara geometris sering dikaitkan dengan luas daerah.']]
            ]]],
            ['title' => 'Visualisasi Grafik', 'type' => 'visualization', 'order' => 2, 'visualization_data' => [
                'title' => 'Integral sebagai Luas Daerah',
                'boundingbox' => [-1, 5, 5, -1],
                'elements' => [
                    ['type' => 'integral', 'formula' => '0.5*x + 1', 'start' => 1, 'end' => 4, 'color' => '#3b82f6'],
                    ['type' => 'function', 'formula' => '0.5*x + 1', 'color' => '#1e293b'],
                ],
                'footer' => 'Daerah yang diarsir biru adalah nilai dari \(\int_{1}^{4} (0.5x + 1) dx\).'
            ]],
            ['title' => 'Notasi Integral Tentu', 'type' => 'content', 'order' => 3, 'content' => ['blocks' => [
                ['type' => 'math', 'data' => ['formula' => '\int_{a}^{b} f(x) dx']],
                ['type' => 'paragraph', 'data' => ['text' => 'Keterangan:<br>1. \(a\) : Batas bawah integrasi.<br>2. \(b\) : Batas atas integrasi.']]
            ]]]
        ]);
        $q2_1 = Quiz::create(['lesson_id' => $l2_1->id, 'title' => 'Kuis Batas Integrasi', 'description' => 'Uji notasi', 'passing_score' => 80]);
        $q2_1_1 = Question::create(['quiz_id' => $q2_1->id, 'question_text' => 'Apa hasil akhir dari perhitungan integral tentu?', 'points' => 100]);
        Option::create(['question_id' => $q2_1_1->id, 'option_text' => 'Sebuah Nilai/Angka Konstan', 'is_correct' => true]);
        Option::create(['question_id' => $q2_1_1->id, 'option_text' => 'Sebuah Fungsi Baru (+C)', 'is_correct' => false]);

        // Materi 2.2: Teorema Dasar Kalkulus II
        $l2_2 = Lesson::create(['topic_id' => $w2->id, 'title' => 'Teorema Dasar Kalkulus II', 'order' => 2, 'xp_reward' => 45, 'content' => '']);
        $l2_2->slides()->createMany([
            ['title' => 'Rumus Utama', 'type' => 'content', 'order' => 1, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Prosedur Hitung', 'level' => 2]],
                ['type' => 'math', 'data' => ['formula' => '\int_{a}^{b} f(x) dx = [F(x)]_{a}^{b} = F(b) - F(a)']],
                ['type' => 'paragraph', 'data' => ['text' => 'Langkah:<br>1. Cari antiturunan \(F(x)\).<br>2. Masukkan batas atas \(b\).<br>3. Masukkan batas bawah \(a\).<br>4. Kurangkan keduanya.']]
            ]]],
            ['title' => 'Contoh Soal', 'type' => 'content', 'order' => 2, 'content' => ['blocks' => [
                ['type' => 'paragraph', 'data' => ['text' => 'Hitung \(\int_{1}^{3} 2x dx\).']],
                ['type' => 'paragraph', 'data' => ['text' => '1. Antiturunan \(2x\) adalah \(x^2\).']],
                ['type' => 'math', 'data' => ['formula' => '[x^2]_{1}^{3} = (3^2) - (1^2) = 9 - 1 = 8']]
            ]]]
        ]);
        $q2_2 = Quiz::create(['lesson_id' => $l2_2->id, 'title' => 'Kuis Kalkulus II', 'description' => 'Hitung nilai integral', 'passing_score' => 80]);
        $q2_2_1 = Question::create(['quiz_id' => $q2_2->id, 'question_text' => 'Hitunglah \(\int_{0}^{2} 3x^2 dx\).', 'points' => 100]);
        Option::create(['question_id' => $q2_2_1->id, 'option_text' => '8', 'is_correct' => true]);
        Option::create(['question_id' => $q2_2_1->id, 'option_text' => '4', 'is_correct' => false]);

        // Materi 2.3: Sifat-Sifat Integral Tentu
        $l2_3 = Lesson::create(['topic_id' => $w2->id, 'title' => 'Sifat-Sifat Integral Tentu', 'order' => 3, 'xp_reward' => 40, 'content' => '']);
        $l2_3->slides()->createMany([
            ['title' => 'Batas yang Sama', 'type' => 'content', 'order' => 1, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Batas Identik', 'level' => 3]],
                ['type' => 'math', 'data' => ['formula' => '\int_{a}^{a} f(x) dx = 0']],
                ['type' => 'paragraph', 'data' => ['text' => 'Jika batas atas dan bawah sama, maka luas daerahnya adalah nol.']]
            ]]],
            ['title' => 'Pembalikan Batas', 'type' => 'content', 'order' => 2, 'content' => ['blocks' => [
                ['type' => 'header', 'data' => ['text' => 'Menukar Batas', 'level' => 3]],
                ['type' => 'math', 'data' => ['formula' => '\int_{a}^{b} f(x) dx = -\int_{b}^{a} f(x) dx']]
            ]]]
        ]);
        $q2_3 = Quiz::create(['lesson_id' => $l2_3->id, 'title' => 'Kuis Sifat Integral', 'description' => 'Uji pemahaman sifat', 'passing_score' => 80]);
        $q2_3_1 = Question::create(['quiz_id' => $q2_3->id, 'question_text' => 'Berapakah nilai dari \(\int_{5}^{5} x^{100} dx\)?', 'points' => 100]);
        Option::create(['question_id' => $q2_3_1->id, 'option_text' => '0', 'is_correct' => true]);
        Option::create(['question_id' => $q2_3_1->id, 'option_text' => '5^101 / 101', 'is_correct' => false]);

        // Evaluasi Akhir Bab 2
        $qf2 = Quiz::create(['topic_id' => $w2->id, 'title' => 'Evaluasi Akhir: Integral Tentu', 'description' => 'Ujian komprehensif Bab 2', 'passing_score' => 80]);
        $qf2_1 = Question::create(['quiz_id' => $qf2->id, 'question_text' => 'Manakah pernyataan yang benar?', 'points' => 100]);
        Option::create(['question_id' => $qf2_1->id, 'option_text' => 'Integral tentu dari a ke a selalu nol', 'is_correct' => true]);
        Option::create(['question_id' => $qf2_1->id, 'option_text' => 'Integral tentu selalu menghasilkan fungsi x', 'is_correct' => false]);

        // 4. BAB 3: TEKNIK SUBSTITUSI
        $w3 = Topic::create(['title' => 'Teknik Substitusi', 'description' => 'Metode u-substitution untuk integral kompleks.', 'order' => 3, 'required_level' => 2]);
        Lesson::create(['topic_id' => $w3->id, 'title' => 'Metode Substitusi Sederhana', 'order' => 1, 'xp_reward' => 60, 'content' => '']);
        Quiz::create(['topic_id' => $w3->id, 'title' => 'Evaluasi Akhir: Substitusi', 'description' => 'Ujian Bab 3', 'passing_score' => 80]);

        // 5. BAB 4: INTEGRAL TRIGONOMETRI
        $w4 = Topic::create(['title' => 'Integral Trigonometri', 'description' => 'Pengintegralan fungsi sin, cos, dan tan.', 'order' => 4, 'required_level' => 3]);
        Lesson::create(['topic_id' => $w4->id, 'title' => 'Integral Sinus dan Kosinus', 'order' => 1, 'xp_reward' => 60, 'content' => '']);
        Quiz::create(['topic_id' => $w4->id, 'title' => 'Evaluasi Akhir: Trigonometri', 'description' => 'Ujian Bab 4', 'passing_score' => 80]);

        // 6. BAB 5: LUAS DAERAH
        $w5 = Topic::create(['title' => 'Aplikasi: Luas Daerah', 'description' => 'Menghitung luas di bawah kurva.', 'order' => 5, 'required_level' => 4]);
        Lesson::create(['topic_id' => $w5->id, 'title' => 'Luas Antara Kurva dan Sumbu X', 'order' => 1, 'xp_reward' => 70, 'content' => '']);
        Quiz::create(['topic_id' => $w5->id, 'title' => 'Evaluasi Akhir: Luas Daerah', 'description' => 'Ujian Bab 5', 'passing_score' => 80]);

        // 7. BAB 6: INTEGRAL PARSIAL
        $w6 = Topic::create(['title' => 'Teknik Integrasi Parsial', 'description' => 'Metode pengalian turunan (LIATE).', 'order' => 6, 'required_level' => 5]);
        Lesson::create(['topic_id' => $w6->id, 'title' => 'Konsep Integral Parsial', 'order' => 1, 'xp_reward' => 80, 'content' => '']);
        Quiz::create(['topic_id' => $w6->id, 'title' => 'Evaluasi Akhir: Parsial', 'description' => 'Ujian Bab 6', 'passing_score' => 80]);

        // Call additional expansion seeders if needed
        $this->call(ContentExpansionSeeder::class);
    }
}
