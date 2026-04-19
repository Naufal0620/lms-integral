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
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin & Students with formal data
        User::create([
            'name' => 'Administrator LMS',
            'email' => 'admin@integral.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'level' => 1,
            'xp' => 0,
            'coins' => 0,
        ]);

        User::create([
            'name' => 'Budi Setiawan',
            'email' => 'budi@mahasiswa.ac.id',
            'password' => Hash::make('password'),
            'role' => 'student',
            'level' => 1,
            'xp' => 0,
            'coins' => 0,
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@mahasiswa.ac.id',
            'password' => Hash::make('password'),
            'role' => 'student',
            'level' => 1,
            'xp' => 0,
            'coins' => 0,
        ]);

        // 2. Bab 1: Dasar-Dasar Integral (Integral Tak Tentu)
        $w1 = Topic::create([
            'title' => 'Dasar-Dasar Integral',
            'description' => 'Mempelajari konsep antiturunan, notasi integral, dan aturan pangkat dasar untuk fungsi aljabar.',
            'order' => 1,
            'required_level' => 1,
        ]);

        Lesson::create([
            'topic_id' => $w1->id,
            'title' => 'Konsep Antiturunan',
            'content' => 'Integral tak tentu pada dasarnya adalah operasi kebalikan dari turunan, yang disebut sebagai antiturunan.' . "\n\n" . 
                         'Jika kita memiliki fungsi \(f(x)\), maka antiturunannya adalah fungsi \(F(x)\) sedemikian rupa sehingga \(F\'(x) = f(x)\).' . "\n\n" . 
                         'Contoh Dasar:' . "\n" . 
                         'Jika \(F(x) = x^2\), maka turunannya adalah \(2x\). Sebaliknya, integral dari \(2x\) adalah \(x^2\).',
            'order' => 1,
            'xp_reward' => 20,
        ]);

        Lesson::create([
            'topic_id' => $w1->id,
            'title' => 'Konstanta Integrasi (+C)',
            'content' => 'Mengapa kita selalu menambahkan \(+C\) di akhir integral tak tentu?' . "\n\n" . 
                         'Perhatikan fungsi-fungsi berikut:' . "\n" . 
                         '1. \(y = x^2 + 5\)' . "\n" . 
                         '2. \(y = x^2 - 10\)' . "\n" . 
                         '3. \(y = x^2 + 100\)' . "\n\n" . 
                         'Ketiganya memiliki turunan yang sama, yaitu \(2x\). Karena turunan dari konstanta adalah nol, kita kehilangan informasi tentang nilai konstanta asli saat melakukan integrasi. Oleh karena itu, kita melambangkannya dengan \(C\).',
            'order' => 2,
            'xp_reward' => 25,
        ]);

        Lesson::create([
            'topic_id' => $w1->id,
            'title' => 'Aturan Pangkat Aljabar',
            'content' => 'Ini adalah aturan paling mendasar dalam integrasi fungsi aljabar.' . "\n\n" . 
                         'Rumus:' . "\n" . 
                         '$$\int x^n dx = \frac{1}{n+1} x^{n+1} + C, \quad n \neq -1$$' . "\n\n" . 
                         'Penting: Aturan ini berlaku untuk semua bilangan real \(n\) kecuali \(-1\). Mari kita lihat berbagai kasusnya di slide berikutnya.',
            'order' => 3,
            'xp_reward' => 30,
        ]);

        Lesson::create([
            'topic_id' => $w1->id,
            'title' => 'Sifat Linearitas Integral',
            'content' => 'Sifat linearitas memungkinkan kita untuk menyelesaikan integral dari penjumlahan fungsi atau fungsi dengan koefisien skalar.' . "\n\n" . 
                         '1. Aturan Skalar:' . "\n" . 
                         '$$\int k \cdot f(x) dx = k \int f(x) dx$$' . "\n\n" . 
                         '2. Aturan Penjumlahan/Pengurangan:' . "\n" . 
                         '$$\int [f(x) \pm g(x)] dx = \int f(x) dx \pm \int g(x) dx$$',
            'order' => 4,
            'xp_reward' => 35,
        ]);

        $q1 = Quiz::create([
            'topic_id' => $w1->id,
            'title' => 'Latihan Kompetensi 1',
            'description' => 'Evaluasi pemahaman mengenai definisi dan sifat-sifat dasar integral tak tentu.',
            'passing_score' => 70,
        ]);

        $ques1 = Question::create(['quiz_id' => $q1->id, 'question_text' => 'Tentukan hasil integrasi dari \(\int (3x^2 + 2x) dx\).', 'points' => 10]);
        Option::create(['question_id' => $ques1->id, 'option_text' => 'x^3 + x^2 + C', 'is_correct' => true]);
        Option::create(['question_id' => $ques1->id, 'option_text' => '3x^3 + 2x^2 + C', 'is_correct' => false]);
        Option::create(['question_id' => $ques1->id, 'option_text' => '6x + 2 + C', 'is_correct' => false]);
        Option::create(['question_id' => $ques1->id, 'option_text' => 'x^3 + x + C', 'is_correct' => false]);

        $ques2 = Question::create(['quiz_id' => $q1->id, 'question_text' => 'Apa peran konstanta C dalam hasil pengintegralan?', 'points' => 10]);
        Option::create(['question_id' => $ques2->id, 'option_text' => 'Sebagai konstanta integrasi (keluarga fungsi)', 'is_correct' => true]);
        Option::create(['question_id' => $ques2->id, 'option_text' => 'Sebagai variabel tambahan', 'is_correct' => false]);
        Option::create(['question_id' => $ques2->id, 'option_text' => 'Sebagai penanda fungsi turunan', 'is_correct' => false]);
        Option::create(['question_id' => $ques2->id, 'option_text' => 'Sebagai nilai rata-rata fungsi', 'is_correct' => false]);

        // 3. Bab 2: Integral Tentu
        $w2 = Topic::create([
            'title' => 'Integral Tentu',
            'description' => 'Menerapkan konsep integral pada interval tertutup untuk menghitung akumulasi atau luas daerah.',
            'order' => 2,
            'required_level' => 1,
        ]);

        Lesson::create([
            'topic_id' => $w2->id,
            'title' => 'Teorema Dasar Kalkulus II',
            'content' => 'Teorema ini menghubungkan konsep turunan dan integral, menyatakan bahwa integral tentu dari suatu fungsi dapat dihitung menggunakan antiturunannya.' . "\n\n" . 
                         '$$\int_{a}^{b} f(x) dx = [F(x)]_{a}^{b} = F(b) - F(a)$$' . "\n\n" . 
                         'Di mana \(F\) adalah antiturunan dari \(f\). Sifat ini memungkinkan kita menghitung nilai eksak dari akumulasi tanpa harus melakukan limit penjumlahan Riemann yang rumit.',
            'order' => 1,
            'xp_reward' => 40,
        ]);

        $q2 = Quiz::create([
            'topic_id' => $w2->id,
            'title' => 'Latihan Kompetensi 2',
            'description' => 'Uji kemampuan dalam menghitung nilai integral tentu pada interval yang diberikan.',
            'passing_score' => 80,
        ]);

        $ques3 = Question::create(['quiz_id' => $q2->id, 'question_text' => 'Hitunglah nilai dari \(\int_{1}^{2} 2x dx\).', 'points' => 20]);
        Option::create(['question_id' => $ques3->id, 'option_text' => '3', 'is_correct' => true]);
        Option::create(['question_id' => $ques3->id, 'option_text' => '4', 'is_correct' => false]);
        Option::create(['question_id' => $ques3->id, 'option_text' => '2', 'is_correct' => false]);
        Option::create(['question_id' => $ques3->id, 'option_text' => '5', 'is_correct' => false]);

        // 4. Bab 3: Teknik Integrasi Substitusi
        $w3 = Topic::create([
            'title' => 'Teknik Integrasi Substitusi',
            'description' => 'Metode substitusi digunakan untuk menyelesaikan integral dengan menyederhanakan bentuk fungsi melalui variabel perantara.',
            'order' => 3,
            'required_level' => 1,
        ]);

        Lesson::create([
            'topic_id' => $w3->id,
            'title' => 'Metode Substitusi Sederhana',
            'content' => 'Metode substitusi adalah teknik yang membalikkan aturan rantai dalam turunan. Tujuannya adalah untuk mengubah bentuk integral yang rumit menjadi bentuk standar yang lebih mudah diselesaikan.' . "\n\n" . 
                         'Langkah-langkah Utama:' . "\n" . 
                         '1. Tentukan bagian fungsi yang akan dijadikan \(u\). Pilih bagian yang jika diturunkan, hasilnya ada di dalam integral tersebut.' . "\n" . 
                         '2. Hitung turunan \(u\) terhadap \(x\) untuk mendapatkan \(du = f\'(x) dx\).' . "\n" . 
                         '3. Substitusikan \(u\) dan \(du\) ke dalam integral asli.' . "\n" . 
                         '4. Selesaikan integral dalam variabel \(u\), lalu kembalikan ke variabel \(x\).' . "\n\n" . 
                         'Contoh: ' . "\n" . 
                         '$$\int (2x+1)^5 dx$$' . "\n" . 
                         'Misalkan \(u = 2x+1\), maka \(du = 2 dx\) atau \(dx = \frac{1}{2} du\).' . "\n" . 
                         'Integral menjadi: \(\int u^5 \cdot \frac{1}{2} du = \frac{1}{2} \cdot \frac{1}{6} u^6 + C = \frac{1}{12}(2x+1)^6 + C\).',
            'order' => 1,
            'xp_reward' => 60,
        ]);

        // 5. Bab 4: Integral Fungsi Trigonometri
        $w4 = Topic::create([
            'title' => 'Integral Fungsi Trigonometri',
            'description' => 'Mempelajari teknik pengintegralan untuk fungsi-fungsi sinus, kosinus, dan fungsi trigonometri lainnya.',
            'order' => 4,
            'required_level' => 1,
        ]);

        Lesson::create([
            'topic_id' => $w4->id,
            'title' => 'Integral Sinus dan Kosinus',
            'content' => 'Pengintegralan fungsi trigonometri dasar memerlukan pemahaman tentang turunan trigonometri yang dibalik.' . "\n\n" . 
                         'Rumus Dasar Pengintegralan:' . "\n" . 
                         '$$\int \sin(x) dx = -\cos(x) + C$$' . "\n" . 
                         '$$\int \cos(x) dx = \sin(x) + C$$' . "\n\n" . 
                         'Perlu diperhatikan tanda negatif pada hasil integral sinus, hal ini dikarenakan turunan dari \(\cos(x)\) adalah \(-\sin(x)\). Untuk fungsi dengan argumen linear seperti \(\int \sin(ax+b) dx\), hasilnya adalah \(-\frac{1}{a} \cos(ax+b) + C\).',
            'order' => 1,
            'xp_reward' => 50,
        ]);

        // 6. Bab 5: Aplikasi Integral - Luas Daerah
        $w5 = Topic::create([
            'title' => 'Aplikasi Integral: Luas Daerah',
            'description' => 'Menggunakan integral tentu untuk menghitung luas daerah yang dibatasi oleh kurva dan sumbu koordinat.',
            'order' => 5,
            'required_level' => 1,
        ]);

        Lesson::create([
            'topic_id' => $w5->id,
            'title' => 'Luas di Bawah Kurva',
            'content' => 'Salah satu aplikasi paling nyata dari integral tentu adalah menghitung luas daerah yang memiliki batas melengkung (kurva).' . "\n\n" . 
                         'Jika sebuah fungsi \(f(x)\) bernilai positif (berada di atas sumbu X) pada interval \([a, b]\), maka luas daerah antara kurva tersebut dengan sumbu X dihitung dengan:' . "\n" . 
                         '$$L = \int_{a}^{b} f(x) dx$$' . "\n\n" . 
                         'Jika kurva berada di bawah sumbu X, hasil integral akan bernilai negatif, sehingga kita perlu mengambil nilai mutlaknya untuk menyatakan luas daerah.',
            'order' => 1,
            'xp_reward' => 70,
        ]);

        // 7. Bab 6: Teknik Integrasi Parsial
        $w6 = Topic::create([
            'title' => 'Teknik Integrasi Parsial',
            'description' => 'Metode integrasi yang digunakan ketika substitusi gagal, didasarkan pada aturan perkalian turunan.',
            'order' => 6,
            'required_level' => 1,
        ]);

        Lesson::create([
            'topic_id' => $w6->id,
            'title' => 'Konsep Integral Parsial',
            'content' => 'Metode integrasi parsial didasarkan pada aturan perkalian (product rule) pada turunan. Metode ini sangat berguna ketika kita menghadapi perkalian dua fungsi yang berbeda jenis, misalnya polinomial dengan eksponensial.' . "\n\n" . 
                         'Rumus Dasar:' . "\n" . 
                         '$$\int u dv = uv - \int v du$$' . "\n\n" . 
                         'Strategi Memilih \(u\) (Aturan LIATE):' . "\n" . 
                         'Prioritaskan pemilihan \(u\) sesuai urutan: <b>L</b>ogarithmic, <b>I</b>nverse Trig, <b>A</b>lgebraic, <b>T</b>rigonometric, <b>E</b>xponential.' . "\n" .
                         'Pilihlah \(u\) yang jika diturunkan akan menjadi lebih sederhana.',
            'order' => 1,
            'xp_reward' => 80,
        ]);

        // 8. Run Content Expansion
        $this->call(ContentExpansionSeeder::class);

        // 9. Convert existing lesson content to slides
        $this->call(ConvertLessonsToSlidesSeeder::class);
    }
}
