<x-app-layout>
    <div class="py-6 md:py-12 px-2 md:px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-6 md:mb-10">
                <div class="inline-flex items-center justify-center p-2.5 md:p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl mb-3 md:mb-4">
                    <i class='bx bxs-trophy text-3xl md:text-4xl text-indigo-600 dark:text-indigo-400'></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white uppercase tracking-tight italic">
                    Papan Peringkat
                </h2>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1 md:mt-2 font-medium px-4">
                    Jadilah yang terbaik dan kumpulkan XP sebanyak mungkin!
                </p>
            </div>

            <!-- Current User Rank Card -->
            <div class="mb-6 md:mb-8 bg-indigo-600 rounded-[2rem] p-5 md:p-6 text-white shadow-xl shadow-indigo-200 dark:shadow-none relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 md:w-32 h-24 md:h-32 bg-white/10 rounded-full blur-3xl"></div>
                <div class="relative flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 md:gap-5">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-xl md:text-2xl font-black border border-white/30 shrink-0">
                            #{{ $userRank }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-indigo-100 text-[9px] md:text-sm font-bold uppercase tracking-widest truncate">Peringkat Anda</p>
                            <h3 class="text-lg md:text-xl font-black uppercase italic truncate leading-tight">{{ auth()->user()->name }}</h3>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-indigo-100 text-[9px] md:text-sm font-bold uppercase tracking-widest">Total XP</p>
                        <h3 class="text-xl md:text-2xl font-black leading-tight">{{ number_format(auth()->user()->xp) }} <span class="text-[10px] md:text-sm">XP</span></h3>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Table -->
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto overflow-y-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/20">
                                <th class="px-4 md:px-6 py-4 md:py-5 text-[9px] md:text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Rank</th>
                                <th class="px-4 md:px-6 py-4 md:py-5 text-[9px] md:text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Mahasiswa</th>
                                <th class="px-4 md:px-6 py-4 md:py-5 text-[9px] md:text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Level</th>
                                <th class="px-4 md:px-6 py-4 md:py-5 text-[9px] md:text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">XP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                            @foreach($topUsers as $index => $user)
                            <tr class="{{ auth()->id() === $user->id ? 'bg-indigo-50/50 dark:bg-indigo-900/10' : '' }} hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 md:px-6 py-4 md:py-5">
                                    <div class="flex justify-center items-center w-7 h-7 md:w-8 md:h-8">
                                        @if($index == 0)
                                            <div class="w-7 h-7 md:w-8 md:h-8 bg-yellow-400 rounded-lg flex items-center justify-center text-white shadow-lg shadow-yellow-100 dark:shadow-none">
                                                <i class='bx bxs-crown text-base md:text-lg'></i>
                                            </div>
                                        @elseif($index == 1)
                                            <div class="w-7 h-7 md:w-8 md:h-8 bg-slate-300 rounded-lg flex items-center justify-center text-white shadow-lg shadow-slate-100 dark:shadow-none">
                                                <span class="font-black text-xs md:text-sm text-slate-600">2</span>
                                            </div>
                                        @elseif($index == 2)
                                            <div class="w-7 h-7 md:w-8 md:h-8 bg-orange-400 rounded-lg flex items-center justify-center text-white shadow-lg shadow-orange-100 dark:shadow-none">
                                                <span class="font-black text-xs md:text-sm">3</span>
                                            </div>
                                        @else
                                            <span class="font-bold text-slate-400 dark:text-slate-500 text-xs md:text-sm italic">#{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 md:px-6 py-4 md:py-5">
                                    <div class="flex items-center gap-2 md:gap-3">
                                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold border-2 border-white dark:border-slate-800 ring-1 ring-slate-200 dark:ring-slate-600 shrink-0 text-xs md:text-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-700 dark:text-slate-200 text-xs md:text-sm truncate {{ auth()->id() === $user->id ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                                {{ $user->name }}
                                            </p>
                                            @if(auth()->id() === $user->id)
                                                <span class="inline-block text-[7px] md:text-[8px] bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 px-1.5 py-0.5 rounded-full uppercase tracking-tighter font-black">Anda</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 md:px-6 py-4 md:py-5 text-center">
                                    <span class="inline-block px-2 md:px-3 py-0.5 md:py-1 bg-slate-100 dark:bg-slate-700 rounded-lg text-[9px] md:text-xs font-black text-slate-600 dark:text-slate-400 uppercase tracking-tighter border border-slate-200 dark:border-slate-600 whitespace-nowrap">
                                        L <span class="hidden md:inline">VL</span> {{ $user->level }}
                                    </span>
                                </td>
                                <td class="px-4 md:px-6 py-4 md:py-5 text-right">
                                    <span class="font-black text-slate-800 dark:text-white italic text-xs md:text-sm">{{ number_format($user->xp) }}</span>
                                    <span class="text-[8px] md:text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase ml-0.5">XP</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($topUsers->isEmpty())
                <div class="py-20 text-center">
                    <i class='bx bx-user-x text-6xl text-slate-300 dark:text-slate-700 mb-4'></i>
                    <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada data mahasiswa</p>
                </div>
                @endif
            </div>
            
            <!-- Bottom Footer Info -->
            <p class="mt-6 text-center text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                Diperbarui setiap kali mahasiswa menyelesaikan materi
            </p>
        </div>
    </div>
</x-app-layout>
