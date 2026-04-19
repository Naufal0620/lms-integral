<x-app-layout>
    <style>
        :root {
            /* PENGATURAN TAMPILAN MOBILE (3 Posisi) */
            --pos-left-m: -60px;
            --pos-center-m: 0px;
            --pos-right-m: 60px;
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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12">
        <!-- Compact Navigation Header -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('dashboard') }}" class="flex items-center text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition group">
                <i class='bx bx-chevron-left text-2xl mr-1 group-hover:-translate-x-1 transition'></i>
                <span class="text-sm font-bold uppercase tracking-wider">Kembali ke Beranda</span>
            </a>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-full text-[10px] font-black uppercase tracking-widest">
                    Peta Pembelajaran
                </span>
            </div>
        </div>

        <!-- Topic Title Section -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-4xl font-black text-slate-900 dark:text-white leading-tight tracking-tight uppercase italic mb-2">
                {{ $topic->title }}
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-widest">
                Selesaikan materi untuk membuka evaluasi akhir
            </p>
        </div>

        <div class="pb-12 overflow-x-hidden">
            <!-- Topic Info & Global Progress -->
            <div class="grid md:grid-cols-3 gap-6 mb-16">
                <div class="md:col-span-2 bg-white dark:bg-[#1e293b] rounded-[2.5rem] p-8 md:p-10 shadow-xl border-2 border-slate-100 dark:border-white/5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-blue-500/5 rounded-full -mr-20 -mt-20"></div>
                    <div class="relative z-10">
                        <h3 class="text-blue-600 dark:text-blue-500 font-black tracking-[0.3em] uppercase text-[10px] mb-4 italic">Ringkasan Bab</h3>
                        <p class="text-lg text-slate-700 dark:text-slate-300 font-medium leading-relaxed italic">
                            "{{ $topic->description }}"
                        </p>
                    </div>
                </div>

                @php
                    $lessonsCount = $topic->lessons->count();
                    $quizzesCount = $topic->quizzes->count();
                    $totalItems = $lessonsCount + $quizzesCount;
                    $completedLessonsCount = Auth::user()->progress()
                        ->whereIn('lesson_id', $topic->lessons->pluck('id'))
                        ->whereNotNull('completed_at')
                        ->count();
                    $passedQuizzesCount = Auth::user()->attempts()
                        ->whereIn('quiz_id', $topic->quizzes->pluck('id'))
                        ->where('passed', true)
                        ->count();
                    $totalCompleted = $completedLessonsCount + $passedQuizzesCount;
                    $progressPercent = $totalItems > 0 ? ($totalCompleted / $totalItems) * 100 : 0;
                @endphp

                <div class="bg-blue-600 rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-blue-500/20 flex flex-col items-center justify-center text-white relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-full bg-white/10 skew-y-12 transform -translate-y-12"></div>
                    <div class="relative z-10 text-center">
                        <div class="relative w-20 h-20 mb-4 mx-auto">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="50%" cy="50%" r="40%" stroke="rgba(255,255,255,0.2)" stroke-width="6" fill="transparent" />
                                @if($progressPercent > 0)
                                    <circle cx="50%" cy="50%" r="40%" stroke="white" stroke-width="6" fill="transparent" 
                                            stroke-dasharray="100" stroke-dashoffset="{{ 100 - $progressPercent }}"
                                            stroke-linecap="round" class="transition-all duration-1000" />
                                @endif
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center font-black text-xs uppercase italic">
                                {{ round($progressPercent) }}%
                            </div>
                        </div>
                        <h4 class="font-black text-sm uppercase tracking-tighter italic">Progres Belajar</h4>
                        <p class="text-[10px] font-bold text-blue-100 uppercase opacity-80">{{ $totalCompleted }} dari {{ $totalItems }} Selesai</p>
                    </div>
                </div>
            </div>

            <div class="path-container">
                @php 
                    $allLessons = $topic->lessons;
                    $allQuizzes = $topic->quizzes;
                    $totalItems = count($allLessons) + count($allQuizzes);
                    $currentIndex = 0;
                    $previousLessonCompleted = true; // First lesson is always unlocked
                @endphp

                <!-- Lessons Loop -->
                @foreach($allLessons as $index => $lesson)
                    @php
                        $isCompleted = Auth::user()->progress->where('lesson_id', $lesson->id)->where('completed_at', '!=', null)->first();
                        $isLocked = !$previousLessonCompleted;

                        // Logic: First and Last are Center, others alternate Left/Right
                        if ($currentIndex === 0 || $currentIndex === $totalItems - 1) {
                            $positionClass = "pos-center";
                        } else {
                            $positionClass = ($currentIndex % 2 !== 0) ? "pos-left" : "pos-right";
                        }
                        
                        $currentIndex++;
                    @endphp

                    <!-- Lesson Node -->
                    <div class="relative z-10 flex flex-col items-center justify-center w-full {{ $positionClass }}">
                        <a href="{{ $isLocked ? '#' : route('lessons.show', $lesson) }}" class="group relative flex flex-col items-center">
                            <div class="node-blob w-20 h-20 md:w-24 md:h-24 aspect-square square rounded-full flex items-center justify-center relative overflow-hidden
                                {{ $isLocked ? 'bg-slate-200 dark:bg-slate-800 cursor-not-allowed' : ($isCompleted ? 'bg-blue-600 shadow-lg shadow-blue-500/20' : 'bg-blue-500') }}">
                                
                                @if($isLocked)
                                    <i class='bx bxs-lock text-2xl text-slate-400 dark:text-slate-500'></i>
                                @elseif($isCompleted)
                                    <i class='bx bx-check text-3xl text-white'></i>
                                @else
                                    <i class='bx bx-book-open text-3xl text-white'></i>
                                @endif

                                <div class="absolute top-0 left-0 w-full h-1/2 bg-white/10 skew-y-12 transform -translate-y-4"></div>
                            </div>

                            <div class="mt-4 text-center max-w-[120px] md:max-w-[150px]">
                                <h4 class="font-black text-xs md:text-sm {{ $isLocked ? 'text-slate-400 dark:text-slate-500' : 'text-slate-900 dark:text-white' }} uppercase tracking-tighter leading-tight italic">
                                    {{ $lesson->title }}
                                </h4>
                                @if(!$isLocked)
                                    <p class="text-[8px] font-black {{ $isCompleted ? 'text-blue-500' : 'text-slate-400' }} uppercase mt-1">
                                        +{{ $lesson->xp_reward }} XP
                                    </p>
                                @endif
                            </div>
                        </a>
                    </div>

                    @php
                        $previousLessonCompleted = $isCompleted;
                    @endphp
                @endforeach

                <!-- Final Quiz (Boss Node) integrated into the same flow -->
                @foreach($allQuizzes as $quiz)
                    @php
                        $bestAttempt = Auth::user()->attempts()->where('quiz_id', $quiz->id)->orderBy('score', 'desc')->first();
                        $passed = $bestAttempt ? $bestAttempt->passed : false;
                        
                        // Quiz is locked if the last lesson is not completed
                        $isLocked = !$previousLessonCompleted;

                        // Logic for Quiz Position (usually the last node)
                        if ($currentIndex === $totalItems - 1) {
                            $positionClass = "pos-center";
                        } else {
                            $positionClass = ($currentIndex % 2 !== 0) ? "pos-left" : "pos-right";
                        }

                        $currentIndex++;
                    @endphp
                    
                    <div class="relative z-10 flex flex-col items-center w-full {{ $positionClass }}">
                        <a href="{{ $isLocked ? '#' : route('quizzes.show', $quiz) }}" class="group relative flex flex-col items-center">
                            <div class="node-blob w-28 h-28 md:w-36 md:h-36 rounded-[2rem] flex items-center justify-center relative overflow-hidden
                                {{ $isLocked ? 'bg-slate-200 dark:bg-slate-800 cursor-not-allowed' : ($passed ? 'bg-amber-500' : 'bg-amber-400') }} 
                                {{ !$isLocked ? 'border-4' : '' }} {{ $passed ? 'border-amber-200' : 'border-slate-300 dark:border-slate-700' }}">
                                
                                @if($isLocked)
                                    <i class='bx bxs-lock text-4xl text-slate-400 dark:text-slate-500'></i>
                                @else
                                    <i class='bx {{ $passed ? "bx-trophy" : "bxs-star" }} text-5xl text-white {{ !$passed ? "animate-pulse" : "" }}'></i>
                                @endif

                                <div class="absolute top-0 left-0 w-full h-1/2 bg-white/10 skew-y-12 transform -translate-y-4"></div>
                            </div>

                            <div class="mt-6 text-center">
                                <h4 class="font-black text-xl {{ $isLocked ? 'text-slate-400' : 'text-slate-900 dark:text-white' }} uppercase tracking-tighter leading-tight italic">
                                    Evaluasi Akhir
                                </h4>
                                <p class="text-xs font-black text-amber-500 uppercase mt-1">
                                    {{ $quiz->title }}
                                </p>
                                @if($bestAttempt && !$isLocked)
                                    <div class="mt-2 bg-slate-100 dark:bg-white/5 px-3 py-1 rounded-full border border-slate-200 dark:border-white/10">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-600 dark:text-slate-400">Skor Terbaik: {{ round($bestAttempt->score) }}%</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
