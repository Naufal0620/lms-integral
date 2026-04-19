<x-app-layout>
    <div class="py-20 min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full px-4">
            <div class="bg-white dark:bg-[#1e293b] rounded-[3rem] shadow-[0_32px_64px_rgba(0,0,0,0.1)] border-2 border-slate-100 dark:border-white/5 p-10 md:p-16 text-center relative overflow-hidden">

                @if($passed)
                    <!-- Success Background -->
                    <div class="absolute inset-0 bg-emerald-500/5 pointer-events-none"></div>
                    <div class="mb-8 relative">
                        <div class="w-32 h-32 bg-emerald-500 text-white rounded-full mx-auto flex items-center justify-center shadow-2xl shadow-emerald-500/50 animate-bounce">
                            <i class='bx bxs-trophy text-6xl'></i>
                        </div>
                        <div class="absolute inset-0 animate-ping opacity-20">
                            <div class="w-32 h-32 bg-emerald-500 rounded-full mx-auto"></div>
                        </div>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-emerald-600 mb-4 uppercase tracking-tighter italic">EVALUASI BERHASIL!</h2>
                @else
                    <!-- Failure Background -->
                    <div class="absolute inset-0 bg-red-500/5 pointer-events-none"></div>
                    <div class="mb-8 relative">
                        <div class="w-32 h-32 bg-slate-800 text-white rounded-full mx-auto flex items-center justify-center shadow-2xl shadow-slate-900/50">
                            <i class='bx bxs-error-circle text-6xl'></i>
                        </div>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-800 dark:text-white mb-4 uppercase tracking-tighter italic">EVALUASI BELUM LULUS</h2>
                @endif

                <p class="text-slate-500 dark:text-slate-400 text-lg font-medium mb-10 leading-relaxed">
                    {{ $message }}
                </p>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-6 mb-12">
                    <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-3xl border-2 border-slate-100 dark:border-white/5">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Skor Akhir</div>
                        <div class="text-3xl font-black text-slate-900 dark:text-white italic">{{ round($score) }}%</div>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-3xl border-2 border-slate-100 dark:border-white/5">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Status</div>
                        <div class="text-xl font-black {{ $passed ? 'text-emerald-500' : 'text-red-500' }} uppercase italic tracking-tighter">
                            {{ $passed ? 'LULUS' : 'BELUM LULUS' }}
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('topics.show', $topic_id) }}" class="rpg-button w-full block bg-blue-600 text-white font-black py-5 rounded-2xl uppercase tracking-tighter italic text-xl shadow-xl shadow-blue-500/20">
                        {{ $passed ? 'Lanjutkan Pembelajaran' : 'Kembali ke Daftar Materi' }}
                    </a>
                    
                    @if(!$passed)
                        <a href="{{ route('quizzes.show', $quiz) }}" class="w-full block bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-300 font-bold py-4 rounded-2xl uppercase tracking-widest text-sm hover:bg-slate-200 transition-colors">
                            Coba Evaluasi Lagi
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
