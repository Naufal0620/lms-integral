# Integral Learning: LMS Tergamifikasi untuk Kalkulus Integral

**Integral Learning** adalah sebuah Learning Management System (LMS) modern yang dirancang khusus untuk mengajarkan materi Kalkulus Integral kepada mahasiswa dengan pendekatan **gamifikasi terstruktur**. Website ini mengubah proses belajar yang kompleks menjadi pengalaman belajar yang interaktif dan memotivasi.

## 🚀 Fitur Utama (Sistem Gamifikasi)

### 1. Antarmuka Belajar Terstruktur (Duolingo-Style)
*   **Peta Pembelajaran:** Materi dibagi menjadi beberapa "Bab" (Topik) dengan alur progresif dalam bentuk node-based map.
*   **Sistem Leveling:** Mahasiswa mengumpulkan XP dari setiap materi untuk naik level.
*   **Currency System:** Koin didapatkan setelah menyelesaikan evaluasi akhir di setiap bab.
*   **Dual Mode (Dark/Light):** Mendukung mode gelap dan mode terang untuk kenyamanan belajar.

### 2. Konten & Evaluasi Interaktif
*   **Materi Berjenjang (Slides):** Pembelajaran dilakukan blok-per-blok menggunakan sistem slide interaktif dengan dukungan multimedia.
*   **Block-Based Editor (Editor.js):** Pembuatan materi yang fleksibel menggunakan sistem blok (Paragraf, Header, Math, Visualisasi).
*   **JSXGraph Engine:** Visualisasi matematika profesional yang interaktif dan akurat secara matematis (Plotting fungsi, Integral tentu).
*   **MathJax Rendering:** Dukungan penuh untuk notasi matematika LaTeX (Standard Inline: `\(...\)`, Display: `$$...$$`).

### 3. Panel Administrasi
*   **Manajemen Konten:** Fitur CRUD lengkap untuk Materi (Lessons) dan Evaluasi (Quizzes).
*   **Visual Designer:** Antarmuka Wizard untuk menyusun grafik JSXGraph dengan pratinjau langsung.
*   **Automatic Slide Creation:** Pembuatan slide dasar secara otomatis saat materi baru didaftarkan.

---

## 🛠️ Stack Teknologi
*   **Framework:** Laravel 12 (PHP 8.2+)
*   **Frontend:** Blade Templates, Tailwind CSS v4, Alpine.js
*   **Rich Text Editor:** Editor.js v2.30+
*   **Math Engine:** MathJax v3 (CDN)
*   **Graphic Engine:** JSXGraph v1.10+ (CDN)
*   **Icons:** Boxicons v2.1.4 (CDN)

---

## 🏗️ Log Pengembangan Terkini
1.  **3-Position Wavy Layout:** Penyederhanaan tata letak peta pembelajaran menjadi 3 posisi (Kiri, Tengah, Kanan) dengan aturan simetris: node pertama dan terakhir selalu di tengah.
2.  **CSS Variables Positioning:** Pemindahan kontrol posisi horizontal dan jarak vertikal (gap) ke dalam CSS Variables (:root) untuk kemudahan kustomisasi terpisah antara Mobile dan Desktop.
3.  **Integrasi Alur Evaluasi:** Penyatuan node "Evaluasi Akhir" (Quiz) ke dalam satu kontainer `path-container` yang sama dengan materi agar mengikuti sistem gap yang konsisten.
4.  **Flat Node UI:** Penghapusan class `rpg-button` dan bayangan tebal pada node pembelajaran untuk tampilan yang lebih minimalis dan modern.
5.  **Sequential Locking System:** Implementasi logika penguncian berurutan; Bab atau Materi selanjutnya hanya akan terbuka jika Bab/Materi sebelumnya telah diselesaikan sepenuhnya.
6.  **Fix UI Overlap (Mobile):** Pemindahan indikator "Slide X dari X" ke posisi atas tengah di dalam konten untuk menghindari tabrakan visual dengan judul materi di layar kecil.
7.  **Scrollbar-in-Card Fix:** Implementasi teknik pemisahan layer frame card dan area scroll agar scrollbar tidak "bocor" keluar dari lengkungan sudut card (rounded corner).
8.  **Global Thin Scrollbar:** Penambahan gaya scrollbar tipis yang elegan di seluruh aplikasi untuk estetika UI yang lebih halus.
9.  **Editor.js Integration:** Transformasi sistem input materi dari textarea statis menjadi Block Editor menggunakan Editor.js, mendukung penulisan konten yang terstruktur.
10. **Custom JSXGraph Tool:** Pembuatan plugin khusus Editor.js untuk menyisipkan grafik matematika JSXGraph langsung di dalam aliran materi.
11. **JSXGraph Visual Designer:** Implementasi Wizard berbasis koordinat di panel Admin yang memungkinkan pembuatan grafik (f(x), Integral, Titik) dengan fitur **Live Preview**.
12. **Dark Mode Canvas:** Otomatisasi penyesuaian warna sumbu, teks, dan latar belakang JSXGraph mengikuti tema aplikasi (Dark/Light).
13. **Lazy Initialization Visualization:** Implementasi sistem pendeteksi visibilitas slide untuk memastikan grafik JSXGraph merender ukurannya secara akurat saat slide dibuka (mengatasi masalah 0x0 pada slide tersembunyi).
14. **Safe Math Evaluation:** Penggantian logika `eval()` lama dengan fungsi `safeEval` yang kompatibel dengan Strict Mode browser modern untuk pemrosesan rumus fungsi matematika.
15. **Refaktor Admin CRUD:** Stabilisasi alur tambah/edit/hapus untuk Bab, Materi, dan Kuis, termasuk penghapusan berantai (*cascade delete*) yang aman di database.
16. **Robust JSXGraph Rendering:** Perbaikan sistem inisialisasi grafik yang sekarang menunggu visibilitas dan ukuran elemen yang valid sebelum merender (mengatasi masalah grafik blank).
17. **Full Data Pass-through:** Optimasi `editorjs-renderer` agar meneruskan seluruh payload data visualisasi dari Editor.js ke komponen Blade tanpa filter, memastikan atribut `elements` dan `boundingbox` diterima utuh.
18. **Advanced Formula Parsing:** Implementasi pembersihan dan ekstraksi rumus otomatis dari notasi LaTeX integral ke dalam format yang dapat dievaluasi oleh JavaScript secara aman.
19. **Modernized Visualization Seeders:** Pembaruan seluruh data seeder (Slide & Example) untuk menggunakan skema `elements` berbasis koordinat matematika asli, menggantikan format `path` SVG statis yang lama.

---

## 🏗️ Mandat Pengembangan (Untuk AI/Developer)
1.  **Konsistensi Istilah:** Gunakan "Mahasiswa", "Bab", "Materi", dan "Evaluasi".
2.  **Layout Peta Pembelajaran:** Selalu gunakan pola 3-posisi (`pos-left`, `pos-center`, `pos-right`) dengan node pertama dan terakhir dipaksa ke tengah (`pos-center`).
3.  **Kontrol Visual:** Pengaturan posisi horizontal dan gap vertikal wajib dilakukan melalui variabel CSS di blok `:root` file terkait.
4.  **MathJax Standard:** Selalu gunakan `\(...\)` untuk rumus di dalam kalimat.
5.  **Block-based Content:** Semua materi baru wajib dibuat menggunakan Editor.js dan dirender melalui komponen `x-editorjs-renderer`.
6.  **JSXGraph for Graphics:** Gunakan library JSXGraph untuk semua visualisasi matematika; hindari penggunaan SVG mentah agar konten mudah diedit di panel Admin.
7.  **No SVG Connectors:** Jangan gunakan garis penghubung berbasis SVG antar node; fokus pada estetika alur node yang meliuk secara mandiri.
8.  **Perfect Circles:** Selalu gunakan class `aspect-square` pada elemen bulat untuk menjamin rasio 1:1.
9.  **Admin Protection:** Semua route manajerial wajib dilindungi oleh `AdminMiddleware`.
