<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Integral Learning - Tingkatkan Pemahaman Kalkulus Anda!</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- MathJax -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .game-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 2px solid transparent; }
        .game-card:hover { transform: translateY(-10px) scale(1.02); }
        .floating { animation: floating 3s ease-in-out infinite; }
        @keyframes floating { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .rpg-button { box-shadow: 0 4px 0 #1e40af; transition: all 0.1s; }
        .rpg-button:active { box-shadow: 0 0 0 #1e40af; transform: translateY(4px); }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#0f172a] text-slate-900 dark:text-slate-200 antialiased overflow-x-hidden transition-colors duration-300">

    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-500/10 dark:bg-blue-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-500/10 dark:bg-indigo-900/20 rounded-full blur-[120px]"></div>
    </div>

    <!-- Navigasi -->
    <nav class="fixed w-full z-50 bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-xl border-b border-slate-200 dark:border-white/10 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 md:h-20 items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/50">
                        <i class='bx bxs-graduation text-white text-lg md:text-xl'></i>
                    </div>
                    <span class="text-xl md:text-2xl font-black tracking-tighter text-slate-900 dark:text-white uppercase">INTEGRAL<span class="text-blue-600 italic">LEARNING</span></span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6 lg:space-x-8 items-center font-bold uppercase text-[10px] tracking-widest">
                    <a href="#home" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 transition">Beranda</a>
                    <a href="#features" class="hover:text-blue-600 transition">Fitur</a>
                    <a href="#about" class="hover:text-blue-600 transition">Tentang</a>
                    <a href="#contact" class="hover:text-blue-600 transition">Kontak</a>
                    
                    <button id="theme-toggle" class="p-2 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 transition">
                        <svg class="theme-toggle-dark-icon hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg class="theme-toggle-light-icon hidden w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>

                    @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rpg-button bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-500 transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-slate-500 dark:text-slate-400 hover:text-blue-600 transition lowercase">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rpg-button bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-500 transition lowercase">Daftar</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center space-x-4">
                    <button id="theme-toggle-mobile" class="p-2 rounded-lg bg-slate-100 dark:bg-white/5 transition">
                        <svg class="theme-toggle-dark-icon hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg class="theme-toggle-light-icon hidden w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>
                    <button id="mobile-menu-button" class="text-slate-900 dark:text-white p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-[#0f172a] border-b border-slate-200 dark:border-white/10 px-4 py-6 space-y-4">
            <a href="#home" class="block font-bold text-blue-600">Beranda</a>
            <a href="#features" class="block font-bold">Fitur</a>
            <a href="#about" class="block font-bold">Tentang</a>
            <a href="#contact" class="block font-bold">Kontak</a>
            <hr class="border-slate-100 dark:border-white/5">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block font-bold text-blue-600">Dashboard</a>
                @else
                    <div class="flex flex-col space-y-4 pt-2">
                        <a href="{{ route('login') }}" class="text-center font-bold">Masuk</a>
                        <a href="{{ route('register') }}" class="rpg-button bg-blue-600 text-white py-3 rounded-lg text-center font-bold uppercase">Mulai Belajar</a>
                    </div>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative pt-24 pb-16 md:pt-40 md:pb-32 z-10 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="space-y-6 md:space-y-8 text-center lg:text-left">
                    <div class="inline-flex items-center space-x-3 bg-blue-500/10 text-blue-600 dark:text-blue-400 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border border-blue-500/20">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                        <span>Platform Belajar Kalkulus Interaktif</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl lg:text-8xl font-black text-slate-900 dark:text-white leading-tight md:leading-[0.9] tracking-tighter">
                        MENJADI <br class="hidden lg:block"><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-500 uppercase">MAHASISWA UNGGUL.</span>
                    </h1>
                    <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium px-4 lg:px-0">
                        Kuasai konsep kalkulus integral dengan sistem pembelajaran terstruktur. Dapatkan poin, level, dan evaluasi pemahaman Anda di setiap materi!
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6 justify-center lg:justify-start pt-4">
                        <a href="{{ route('register') }}" class="rpg-button inline-flex items-center justify-center px-8 md:px-10 py-4 md:py-5 bg-blue-600 text-white font-black rounded-xl hover:bg-blue-500 transition text-lg md:text-xl group uppercase tracking-tighter italic">
                            Mulai Belajar
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2 group-hover:translate-x-2 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center px-8 md:px-10 py-4 md:py-5 bg-slate-200 dark:bg-white/5 text-slate-800 dark:text-white font-bold rounded-xl border border-slate-300 dark:border-white/10 hover:bg-slate-300 dark:hover:bg-white/10 transition text-lg md:text-xl">
                            Lihat Fitur
                        </a>
                    </div>
                </div>

                <div class="relative flex justify-center mt-12 lg:mt-0">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-64 h-64 md:w-[120%] md:h-[120%] border-2 border-blue-500/20 rounded-full animate-[spin_20s_linear_infinite]"></div>
                    </div>
                    
                    <div class="relative floating scale-90 md:scale-100">
                        <!-- Mockup Smartphone -->
                        <div class="relative mx-auto border-slate-800 dark:border-slate-700 bg-slate-800 border-[12px] rounded-[3rem] h-[550px] w-[280px] shadow-2xl overflow-hidden shadow-blue-500/20">
                            <!-- Notch -->
                            <div class="absolute -top-1 inset-x-0 flex justify-center z-20">
                                <div class="bg-slate-800 h-6 w-32 rounded-b-2xl"></div>
                            </div>
                            
                            <!-- Screen Content -->
                            <div class="relative h-full w-full bg-slate-100 dark:bg-slate-900 overflow-hidden">
                                <!-- Placeholder Gambar Beranda Level -->
                                <img src="https://images.unsplash.com/photo-1614332284112-2ad884487a9a?q=80&w=500&auto=format&fit=crop" 
                                     class="w-full h-full object-cover opacity-90 dark:opacity-60" 
                                     alt="Preview App">
                                
                                <!-- Overlay UI (Mocking the App Header/Elements) -->
                                <div class="absolute inset-0 p-5 flex flex-col justify-between pointer-events-none">
                                    <div class="mt-4 flex justify-between items-center bg-white/20 dark:bg-black/40 backdrop-blur-md p-3 rounded-2xl border border-white/20">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-blue-600 rounded-md flex items-center justify-center">
                                                <i class='bx bxs-graduation text-white text-[10px]'></i>
                                            </div>
                                            <span class="text-slate-900 dark:text-white font-black text-[10px] tracking-tighter uppercase">Level 12</span>
                                        </div>
                                        <div class="flex space-x-1">
                                            <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                                            <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                                            <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                        </div>
                                    </div>

                                    <!-- Floating Nodes (Simulating Map) -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="space-y-12">
                                            <div class="w-12 h-12 bg-blue-600 rounded-full border-4 border-white shadow-lg flex items-center justify-center translate-x-10">
                                                <i class='bx bxs-star text-white'></i>
                                            </div>
                                            <div class="w-12 h-12 bg-slate-400 rounded-full border-4 border-white shadow-lg flex items-center justify-center -translate-x-8">
                                                <i class='bx bxs-lock-alt text-white'></i>
                                            </div>
                                            <div class="w-12 h-12 bg-slate-400 rounded-full border-4 border-white shadow-lg flex items-center justify-center translate-x-12 opacity-50">
                                                <i class='bx bxs-lock-alt text-white'></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-blue-600 p-4 rounded-2xl shadow-lg border border-white/20">
                                        <p class="text-white font-black italic text-xs uppercase tracking-tighter mb-1">Materi Berikutnya:</p>
                                        <h5 class="text-white font-bold text-sm leading-tight">Integral Substitusi Lanjut</h5>
                                        <div class="w-full bg-white/20 h-1.5 rounded-full mt-3 overflow-hidden">
                                            <div class="bg-yellow-400 h-full w-[40%]"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dekorasi Tambahan -->
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-yellow-400 rounded-full flex items-center justify-center shadow-xl rotate-12 z-20 border-4 border-white">
                            <i class='bx bxs-trophy text-blue-900 text-4xl'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 md:py-32 bg-slate-100 dark:bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
                <h2 class="text-blue-600 dark:text-blue-500 font-black tracking-[0.3em] uppercase text-[10px] mb-4 italic">Metode Belajar</h2>
                <h3 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tighter uppercase">SISTEM UNGGULAN</h3>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                <!-- Skill 1 -->
                <div class="game-card p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] bg-white dark:bg-[#1e293b] shadow-xl border-2 border-slate-100 dark:border-white/5 relative group">
                    <div class="absolute -top-6 left-8 md:left-10 w-12 h-12 md:w-16 md:h-16 bg-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg">
                        <i class='bx bxs-zap text-white text-3xl md:text-4xl'></i>
                    </div>
                    <div class="mt-6 md:mt-8 text-center md:text-left">
                        <h4 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mb-4 italic uppercase">Sistem XP</h4>
                        <p class="text-sm md:text-base text-slate-600 dark:text-slate-400 font-medium">Kumpulkan poin pengalaman dari setiap materi yang Anda pelajari untuk memantau kemajuan belajar.</p>
                    </div>
                </div>
                
                <!-- Skill 2 -->
                <div class="game-card p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] bg-white dark:bg-[#1e293b] shadow-xl border-2 border-slate-100 dark:border-white/5 relative group">
                    <div class="absolute -top-6 left-8 md:left-10 w-12 h-12 md:w-16 md:h-16 bg-indigo-600 rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg">
                        <i class='bx bxs-map-alt text-white text-3xl md:text-4xl'></i>
                    </div>
                    <div class="mt-6 md:mt-8 text-center md:text-left">
                        <h4 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mb-4 italic uppercase">Peta Materi</h4>
                        <p class="text-sm md:text-base text-slate-600 dark:text-slate-400 font-medium">Alur pembelajaran yang terstruktur memudahkan Anda menavigasi bab demi bab kalkulus integral.</p>
                    </div>
                </div>
                
                <!-- Skill 3 -->
                <div class="game-card p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] bg-white dark:bg-[#1e293b] shadow-xl border-2 border-slate-100 dark:border-white/5 relative group md:col-span-2 lg:col-span-1">
                    <div class="absolute -top-6 left-8 md:left-10 w-12 h-12 md:w-16 md:h-16 bg-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg">
                        <i class='bx bxs-edit text-white text-3xl md:text-4xl'></i>
                    </div>
                    <div class="mt-6 md:mt-8 text-center md:text-left">
                        <h4 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mb-4 italic uppercase">Evaluasi Materi</h4>
                        <p class="text-sm md:text-base text-slate-600 dark:text-slate-400 font-medium">Uji pemahaman Anda melalui kuis interaktif di akhir setiap bab untuk memastikan penguasaan materi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lore Section -->
    <section id="about" class="py-20 md:py-32 px-4 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div class="relative scale-90 md:scale-100">
                    <div class="absolute -inset-4 md:-inset-10 bg-blue-500/10 rounded-full blur-[80px]"></div>
                    <div class="relative bg-white dark:bg-slate-800 p-8 md:p-12 rounded-[2.5rem] shadow-2xl border-2 border-slate-100 dark:border-white/5">
                        <h4 class="text-2xl md:text-3xl font-black text-blue-600 mb-6 md:mb-8 italic uppercase tracking-tighter">Dasar Teorema</h4>
                        <div class="text-xl md:text-2xl text-slate-700 dark:text-slate-300 font-serif leading-relaxed italic space-y-4 md:space-y-6">
                            <p class="text-center">$$\int_{a}^{b} f(x) dx = F(b) - F(a)$$</p>
                            <p class="text-base md:text-lg text-center font-bold">"Pemahaman mendalam lahir dari latihan yang konsisten."</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6 md:space-y-8 text-center lg:text-left">
                    <h2 class="text-blue-600 dark:text-blue-500 font-black tracking-[0.3em] uppercase text-[10px] italic">Filosofi Kami</h2>
                    <h3 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tighter uppercase leading-tight">MENGUBAH CARA BELAJAR</h3>
                    <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 font-medium">Belajar Kalkulus tidak lagi membosankan. Kami mengintegrasikan elemen gamifikasi untuk menjaga motivasi dan fokus Anda dalam belajar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 md:py-32 bg-blue-600 relative overflow-hidden px-4">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 md:gap-20 items-center">
                <div class="text-white space-y-4 md:space-y-6 text-center lg:text-left">
                    <h3 class="text-3xl md:text-5xl font-black tracking-tighter italic uppercase">ADA PERTANYAAN?</h3>
                    <p class="text-blue-100 text-lg md:text-xl font-medium">Kirimkan pesan Anda melalui formulir berikut!</p>
                </div>
                <div class="bg-white rounded-[2rem] md:rounded-[3rem] p-8 md:p-12 shadow-2xl">
                    <form class="space-y-4 md:space-y-6" onsubmit="event.preventDefault(); alert('Pesan Anda telah terkirim!');">
                        @csrf
                        <input type="text" name="hero_name" required placeholder="Nama Lengkap" class="w-full px-6 py-3 md:py-4 rounded-xl border-2 border-slate-100 focus:border-blue-500 outline-none transition text-slate-900 font-bold text-sm md:text-base">
                        <input type="email" name="hero_email" required placeholder="Email Kontak" class="w-full px-6 py-3 md:py-4 rounded-xl border-2 border-slate-100 focus:border-blue-500 outline-none transition text-slate-900 font-bold text-sm md:text-base">
                        <textarea name="hero_message" required placeholder="Pesan Anda..." rows="3" class="w-full px-6 py-3 md:py-4 rounded-xl border-2 border-slate-100 focus:border-blue-500 outline-none transition text-slate-900 font-bold text-sm md:text-base"></textarea>
                        <button type="submit" class="rpg-button w-full bg-blue-600 text-white font-black py-4 md:py-5 rounded-xl text-sm md:text-lg uppercase italic tracking-tighter">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white dark:bg-[#0f172a] py-8 md:py-10 border-t border-slate-200 dark:border-white/5 relative z-10 transition-colors duration-300 px-4">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <div class="flex items-center justify-center space-x-2">
                <div class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center"><i class='bx bxs-graduation text-white text-xs'></i></div>
                <span class="text-base font-black text-slate-900 dark:text-white uppercase tracking-tighter">Integral<span class="text-blue-600">Learning</span></span>
            </div>
            <div class="space-y-1">
                <p class="text-slate-500 text-[10px] md:text-xs font-medium italic">© {{ date('Y') }} Integral Learning System. Dirancang untuk edukasi kalkulus.</p>
                <p class="text-slate-400 dark:text-slate-500 text-[9px] md:text-[10px] font-bold uppercase tracking-widest">Dibuat untuk Projek Mata Kuliah Kalkulus Integral</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if(mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking a link
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });
        }

        // Theme Toggle Logic
        const themeToggleBtns = [document.getElementById('theme-toggle'), document.getElementById('theme-toggle-mobile')];
        
        const updateIcons = () => {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-toggle-dark-icon').forEach(el => el.classList.toggle('hidden', isDark));
            document.querySelectorAll('.theme-toggle-light-icon').forEach(el => el.classList.toggle('hidden', !isDark));
        };

        const toggleTheme = () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
            updateIcons();
        };

        themeToggleBtns.forEach(btn => {
            if(btn) btn.addEventListener('click', toggleTheme);
        });

        // Initialize icons
        updateIcons();
    </script>
</body>
</html>
