<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic mb-1">
                    Halo, <span class="text-blue-600">{{ Auth::user()->name }}</span>!
                </h1>
                <p class="text-slate-500 dark:text-slate-400 font-medium uppercase tracking-widest text-xs">Siap untuk petualangan kalkulus hari ini?</p>
            </div>
            
            <div class="flex items-center space-x-3">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.topics.index') }}" class="rpg-button bg-slate-900 dark:bg-white/10 text-white text-[10px] font-black py-4 px-6 rounded-2xl transition-all flex items-center uppercase tracking-widest italic">
                        <i class='bx bx-cog me-2 text-base'></i> Admin Panel
                    </a>
                @endif
                <div class="bg-blue-600 px-6 py-3 rounded-2xl shadow-lg shadow-blue-500/20 text-white flex flex-col items-center">
                    <span class="text-[8px] font-black uppercase tracking-widest opacity-80 leading-none mb-1">Level</span>
                    <span class="text-xl font-black italic leading-none">LVL {{ Auth::user()->level }}</span>
                </div>
            </div>
        </div>

    <style>
        :root {
            /* PENGATURAN TAMPILAN MOBILE (3 Posisi) */
            --pos-left-m: -70px;
            --pos-center-m: 0px;
            --pos-right-m: 70px;
            --node-gap-m: 50px;

            /* PENGATURAN TAMPILAN DESKTOP (3 Posisi) */
            --pos-left-d: -70px;
            --pos-center-d: 0px;
            --pos-right-d: 70px;
            --node-gap-d: 60px;
        }

        .path-container {
            position: relative;
            padding-bottom: 100px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--node-gap-m);
        }

        @media (min-width: 768px) {
            .path-container {
                gap: var(--node-gap-d);
            }
        }

        .node-blob {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .node-blob:hover {
            transform: scale(1.1);
        }
        
        /* 3-Position Layout */
        .pos-left { transform: translateX(var(--pos-left-m)); }
        .pos-center { transform: translateX(var(--pos-center-m)); }
        .pos-right { transform: translateX(var(--pos-right-m)); }

        @media (min-width: 768px) {
            .pos-left { transform: translateX(var(--pos-left-d)); }
            .pos-center { transform: translateX(var(--pos-center-d)); }
            .pos-right { transform: translateX(var(--pos-right-d)); }
        }
    </style>

    <div class="pb-12 overflow-x-hidden">
        <div>
            @if(session('error'))
                <div class="mb-12 bg-red-500/10 border-2 border-red-500/20 text-red-600 dark:text-red-400 p-5 rounded-2xl shadow-xl flex items-center animate-pulse">
                    <i class='bx bx-error-circle text-2xl mr-4'></i>
                    <p class="font-black uppercase tracking-tighter">{{ session('error') }}</p>
                </div>
            @endif

            <div class="path-container">
                @php 
                    $totalTopics = count($topics);
                    $previousTopicCompleted = true; // First topic is always unlocked
                @endphp
                @foreach($topics as $index => $topic)
                    @php
                        // Comprehensive Progress Calculation for THIS topic
                        $lessonsCount = $topic->lessons->count();
                        $quizzesCount = $topic->quizzes->count();
                        $totalItems = $lessonsCount + $quizzesCount;
                        $completedLessonsCount = Auth::user()->progress()->whereIn('lesson_id', $topic->lessons->pluck('id'))->whereNotNull('completed_at')->count();
                        $passedQuizzesCount = Auth::user()->attempts()->whereIn('quiz_id', $topic->quizzes->pluck('id'))->where('passed', true)->count();
                        $totalCompleted = $completedLessonsCount + $passedQuizzesCount;
                        $progressPercent = $totalItems > 0 ? ($totalCompleted / $totalItems) * 100 : 0;
                        $thisTopicCompleted = ($totalCompleted >= $totalItems) && ($totalItems > 0);

                        // Locking Logic
                        $levelLocked = Auth::user()->level < $topic->required_level;
                        $isLocked = ($index > 0 && !$previousTopicCompleted) || $levelLocked;
                        
                        // Logic: First and Last are Center, others alternate Left/Right
                        if ($index === 0 || $index === $totalTopics - 1) {
                            $positionClass = "pos-center";
                        } else {
                            $positionClass = ($index % 2 !== 0) ? "pos-left" : "pos-right";
                        }
                    @endphp

                    <!-- Topic Node -->
                    <div class="relative z-10 flex flex-col items-center justify-center w-full {{ $positionClass }}">
                        <a href="{{ $isLocked ? '#' : route('topics.show', $topic) }}" 
                           class="group relative flex flex-col items-center">
                            
                            <!-- Progress Ring -->
                            <div class="relative w-28 h-28 md:w-36 md:h-36 flex items-center justify-center">
                                <svg class="absolute inset-0 w-full h-full transform -rotate-90">
                                    <circle cx="50%" cy="50%" r="45%" stroke="currentColor" stroke-width="6" fill="transparent" 
                                            class="text-slate-200 dark:text-slate-800" />
                                    @if(!$isLocked && $progressPercent > 0)
                                        <circle cx="50%" cy="50%" r="45%" stroke="currentColor" stroke-width="6" fill="transparent" 
                                                stroke-dasharray="283" stroke-dashoffset="{{ 283 - (283 * $progressPercent / 100) }}"
                                                class="text-blue-500 transition-all duration-1000" stroke-linecap="round" />
                                    @endif
                                </svg>

                                <!-- The Button/Node -->
                                <div class="node-blob w-20 h-20 md:w-28 md:h-28 aspect-square square rounded-full flex items-center justify-center relative overflow-hidden
                                    {{ $isLocked ? 'bg-slate-200 dark:bg-slate-800 cursor-not-allowed' : 'bg-blue-600 shadow-lg shadow-blue-500/20' }}">
                                    
                                    @if($isLocked)
                                        <i class='bx bxs-lock text-2xl md:text-3xl text-slate-400 dark:text-slate-500'></i>
                                    @elseif($thisTopicCompleted)
                                        <i class='bx bxs-check-shield text-3xl md:text-4xl text-white'></i>
                                    @else
                                        <span class="text-white font-black text-xl md:text-2xl italic uppercase tracking-tighter">{{ $loop->iteration }}</span>
                                    @endif

                                    <!-- Shine effect -->
                                    <div class="absolute top-0 left-0 w-full h-1/2 bg-white/10 skew-y-12 transform -translate-y-4"></div>
                                </div>

                                <!-- Completed Badge -->
                                @if($thisTopicCompleted && !$isLocked)
                                    <div class="absolute -top-1 -right-1 w-8 h-8 md:w-10 md:h-10 bg-yellow-400 rounded-full flex items-center justify-center border-4 border-white dark:border-slate-900 shadow-lg animate-bounce z-20">
                                        <i class='bx bxs-star text-blue-900 text-base md:text-xl'></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Label -->
                            <div class="mt-3 text-center max-w-[120px] md:max-w-[180px]">
                                <h4 class="font-black text-xs md:text-sm {{ $isLocked ? 'text-slate-400' : 'text-slate-900 dark:text-white' }} uppercase tracking-tighter leading-tight italic">
                                    {{ $topic->title }}
                                </h4>
                                @if(!$isLocked)
                                    <p class="text-[8px] font-black text-slate-500 uppercase mt-0.5">
                                        {{ $totalCompleted }}/{{ $totalItems }} Selesai
                                    </p>
                                @endif
                            </div>
                        </a>
                    </div>
                    @php
                        $previousTopicCompleted = $thisTopicCompleted;
                    @endphp
                @endforeach
            </div>

            <!-- Empty State -->
            @if($topics->isEmpty())
                <div class="text-center py-20 bg-white dark:bg-[#1e293b] rounded-[3rem] shadow-xl border-2 border-dashed border-slate-200 dark:border-white/5">
                    <i class='bx bx-map-alt text-6xl text-slate-300 mb-4'></i>
                    <h3 class="font-black text-2xl text-slate-900 dark:text-white uppercase italic">Belum Ada Materi</h3>
                    <p class="text-slate-500 font-medium">Administrator sedang menyiapkan kurikulum terbaik untuk Anda!</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
