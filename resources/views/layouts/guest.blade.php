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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            .rpg-button { box-shadow: 0 4px 0 #1e40af; transition: all 0.1s; }
            .rpg-button:active { box-shadow: 0 0 0 #1e40af; transform: translateY(4px); }
        </style>
    </head>
    <body class="bg-slate-50 dark:bg-[#0f172a] text-slate-900 dark:text-slate-200 antialiased transition-colors duration-300">
        <!-- Background Orbs -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-500/10 dark:bg-blue-900/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-500/10 dark:bg-indigo-900/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10 px-4">
            <div class="mb-8">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/50 group-hover:scale-110 transition duration-300">
                        <span class="text-white font-black text-2xl italic">IQ</span>
                    </div>
                    <span class="text-2xl font-black tracking-tighter text-slate-900 dark:text-white uppercase">INTEGRAL<span class="text-blue-600 italic">QUEST</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md p-8 md:p-10 bg-white dark:bg-[#1e293b] shadow-2xl border-2 border-slate-100 dark:border-white/5 rounded-[2.5rem] overflow-hidden">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest">
                    © {{ date('Y') }} Integral Quest Engine
                </p>
            </div>
        </div>
    </body>
</html>
