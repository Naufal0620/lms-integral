<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Integral Quest') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <!-- Boxicons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
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
            
            /* Custom Thin Scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }
            .dark ::-webkit-scrollbar-thumb {
                background: #334155;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            /* Prevent MathJax overflow from breaking layouts but ensure full visibility */
            .mjx-container {
                max-width: 100% !important;
                overflow-x: visible !important;
                overflow-y: hidden !important;
                padding: 0.5em 0;
                text-align: center;
            }
        </style>
    </head>
    <body class="bg-slate-50 dark:bg-[#0f172a] text-slate-900 dark:text-slate-200 antialiased transition-colors duration-300 min-h-screen">
        
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-slate-900/50 shadow-sm border-b border-slate-100 dark:border-white/5 relative z-30">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="relative z-10">
            {{ $slot }}
        </main>

        <!-- Background Orbs -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-500/10 dark:bg-blue-900/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-500/10 dark:bg-indigo-900/20 rounded-full blur-[120px]"></div>
        </div>

        <!-- Level Up Notification -->
        @if(session('level_up'))
        <div x-data="{ show: true }" x-show="show" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-cloak>
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-8 max-w-sm w-full text-center shadow-2xl relative overflow-hidden border-4 border-blue-600 animate-bounce-subtle"
                 @click.outside="show = false">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 via-indigo-500 to-purple-600"></div>
                <div class="mb-6 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-blue-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-xl rotate-12 relative z-10">
                            <i class='bx bxs-star text-5xl'></i>
                        </div>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tighter mb-2 italic">LEVEL UP!</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-6">Luar biasa! Kamu sekarang berada di <span class="text-blue-600 dark:text-blue-400 font-bold uppercase">Level {{ session('level_up') }}</span></p>
                <button @click="show = false" 
                        class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black uppercase tracking-widest transition shadow-lg shadow-blue-500/20">
                    Lanjutkan Belajar
                </button>
            </div>
        </div>
        <style>
            @keyframes bounce-subtle {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            .animate-bounce-subtle { animation: bounce-subtle 2s infinite ease-in-out; }
            [x-cloak] { display: none !important; }
        </style>
        @endif
    </body>
</html>
