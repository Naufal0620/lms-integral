<x-app-layout>
    <div class="h-[calc(100vh-64px)] h-[calc(100dvh-64px)] overflow-hidden bg-slate-50 dark:bg-[#0f172a]" x-data="{ 
        currentSlide: 0, 
        totalSlides: {{ $lesson->slides->count() }},
        completed: {{ $completed ? 'true' : 'false' }},
        nextSlide() { if(this.currentSlide < this.totalSlides - 1) this.currentSlide++; },
        prevSlide() { if(this.currentSlide > 0) this.currentSlide--; }
    }">
        <div class="max-w-4xl mx-auto h-full flex flex-col px-3 sm:px-6 lg:px-8">
            
            <!-- Compact Header -->
            <div class="py-3 sm:py-4 flex items-center justify-between border-b border-slate-100 dark:border-white/5">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ route('topics.show', $lesson->topic_id) }}" class="p-1.5 sm:p-2 bg-white dark:bg-white/5 rounded-xl hover:bg-slate-100 dark:hover:bg-white/10 transition border border-slate-100 dark:border-white/5">
                        <i class='bx bx-chevron-left text-xl sm:text-2xl text-slate-500'></i>
                    </a>
                    <div class="min-w-0">
                        <h2 class="font-black text-[10px] sm:text-sm text-slate-900 dark:text-white uppercase italic truncate max-w-[120px] sm:max-w-md">
                            {{ $lesson->title }}
                        </h2>
                        <div class="flex items-center space-x-1 mt-0.5 overflow-hidden">
                            <template x-for="i in totalSlides">
                                <div class="h-1 rounded-full transition-all duration-300" 
                                     :class="i-1 <= currentSlide ? 'w-3 sm:w-4 bg-blue-600' : 'w-1 sm:w-2 bg-slate-200 dark:bg-slate-800'"></div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide Container -->
            <div class="flex-grow flex items-center justify-center py-4 sm:py-6 relative overflow-hidden">
                @foreach($lesson->slides as $index => $slide)
                    <div x-show="currentSlide === {{ $index }}" 
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-200 transform absolute"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-8"
                         class="w-full h-full flex flex-col">
                        
                        <div class="w-full h-full flex flex-col bg-white dark:bg-slate-900 rounded-[2rem] sm:rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-white/5 overflow-hidden relative">
                            <!-- Scrollable Content Area -->
                            <div class="flex-grow overflow-y-auto p-5 sm:p-10 md:p-12">
                                <!-- Floating Step Indicator -->
                                <div class="mb-6 flex justify-center">
                                    <span class="text-[8px] sm:text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-[0.2em] bg-blue-50 dark:bg-blue-500/10 px-3 py-1 rounded-full border border-blue-100 dark:border-blue-500/20 shadow-sm">
                                        Slide <span x-text="currentSlide + 1"></span> dari <span x-text="totalSlides"></span>
                                    </span>
                                </div>

                                @if($slide->type === 'content')
                                    <div class="w-full">
                                        <x-editorjs-renderer :content="$slide->content" />
                                    </div>
                                @elseif($slide->type === 'visualization')
                                    {{-- Legacy fallback for visualization type slides --}}
                                    <div class="w-full">
                                        <h3 class="text-lg sm:text-2xl md:text-3xl font-black text-slate-900 dark:text-white uppercase italic mb-5 sm:mb-8 border-l-4 border-blue-600 pl-3 sm:pl-4 leading-tight">
                                            {{ $slide->title ?? 'Visualisasi Konsep' }}
                                        </h3>
                                        <x-visualization :data="$slide->visualization_data" />
                                    </div>
                                @else                                    <div class="flex-grow flex flex-col justify-center" x-data="{ answered: false, correct: false, selected: null }">
                                        @if($slide->questions->isNotEmpty())
                                            <div class="mb-6 sm:mb-10 text-center">
                                                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-full text-[8px] sm:text-[10px] font-black uppercase tracking-[0.2em] italic border border-amber-200 dark:border-amber-500/20">
                                                    Kuis Cepat
                                                </span>
                                                <h3 class="text-lg sm:text-2xl md:text-3xl font-black text-slate-900 dark:text-white italic mt-4 sm:mt-6 leading-tight">
                                                    {{ $slide->questions->first()->question_text }}
                                                </h3>
                                            </div>

                                            <div class="grid gap-3 sm:gap-4 max-w-2xl mx-auto w-full">
                                                @foreach($slide->questions->first()->options as $option)
                                                    <button 
                                                        @click="if(!answered) { answered = true; selected = {{ $option->id }}; correct = {{ $option->is_correct ? 'true' : 'false' }}; }"
                                                        class="relative p-4 sm:p-6 rounded-xl sm:rounded-2xl border-2 transition-all text-left font-bold text-sm sm:text-lg group overflow-hidden"
                                                        :class="{
                                                            'bg-white dark:bg-slate-800 border-slate-100 dark:border-white/5 active:border-blue-500': !answered,
                                                            'bg-emerald-50 dark:bg-emerald-500/10 border-emerald-500 text-emerald-700 dark:text-emerald-400': answered && {{ $option->is_correct ? 'true' : 'false' }},
                                                            'bg-red-50 dark:bg-red-500/10 border-red-500 text-red-700 dark:text-red-400': answered && selected === {{ $option->id }} && !{{ $option->is_correct ? 'true' : 'false' }},
                                                            'bg-slate-50 dark:bg-slate-800/50 border-slate-100 dark:border-white/5 opacity-50': answered && selected !== {{ $option->id }} && !{{ $option->is_correct ? 'true' : 'false' }}
                                                        }">
                                                        <span class="relative z-10">{{ $option->option_text }}</span>
                                                        <div x-show="answered && {{ $option->is_correct ? 'true' : 'false' }}" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2">
                                                            <i class='bx bxs-check-circle text-xl sm:text-2xl'></i>
                                                        </div>
                                                    </button>
                                                @endforeach
                                            </div>

                                            <div x-show="answered" x-transition class="mt-6 sm:mt-8 text-center">
                                                <p x-show="correct" class="text-emerald-600 dark:text-emerald-400 font-black italic uppercase tracking-widest text-[10px] sm:text-sm">Hebat! Jawaban Anda Benar.</p>
                                                <p x-show="!correct" class="text-red-600 dark:text-red-400 font-black italic uppercase tracking-widest text-[10px] sm:text-sm">Ups! Coba perhatikan lagi materinya.</p>
                                            </div>
                                        @else
                                            <div class="text-center py-10">
                                                <i class='bx bx-loader-alt animate-spin text-4xl text-slate-300 mb-4'></i>
                                                <p class="text-slate-500 italic text-sm">Kuis sedang disiapkan...</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Slide Navigation Bar -->
            <div class="py-4 sm:py-6 flex items-center justify-between gap-3 sm:gap-4">
                <button @click="prevSlide" 
                        class="px-4 py-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-slate-200 dark:border-white/5 text-slate-500 dark:text-slate-400 font-black uppercase tracking-tighter italic flex items-center transition active:scale-95 disabled:opacity-0"
                        :disabled="currentSlide === 0">
                    <i class='bx bx-left-arrow-alt text-xl sm:text-2xl sm:mr-2'></i>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </button>

                <div x-show="currentSlide === totalSlides - 1" class="flex-grow sm:flex-grow-0">
                    @if(!$completed)
                        @if($lesson->quiz)
                            <a href="{{ route('quizzes.show', $lesson->quiz) }}" class="w-full rpg-button bg-blue-600 text-white px-6 sm:px-10 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-black text-sm sm:text-lg uppercase tracking-tighter italic flex items-center justify-center space-x-2 transition active:scale-95 shadow-lg shadow-blue-500/20">
                                <span class="whitespace-nowrap text-xs sm:text-lg">Mulai Evaluasi</span>
                                <i class='bx bx-right-arrow-alt text-xl sm:text-2xl'></i>
                            </a>
                        @else
                            <form action="{{ route('lessons.complete', $lesson) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full rpg-button bg-blue-600 text-white px-6 sm:px-10 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-black text-sm sm:text-lg uppercase tracking-tighter italic flex items-center justify-center space-x-2 transition active:scale-95 shadow-lg shadow-blue-500/20">
                                    <span class="whitespace-nowrap text-xs sm:text-lg">Selesaikan Materi</span>
                                    <i class='bx bxs-zap text-xl sm:text-2xl'></i>
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="w-full bg-emerald-500 text-white px-5 sm:px-8 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-black uppercase tracking-widest italic flex items-center justify-center shadow-lg">
                            <i class='bx bxs-check-shield text-xl sm:text-2xl sm:mr-3'></i>
                            <span class="hidden sm:inline text-sm sm:text-base">Selesai</span>
                        </div>
                    @endif
                </div>

                <button @click="nextSlide" 
                        x-show="currentSlide < totalSlides - 1"
                        class="flex-grow sm:flex-grow-0 rpg-button bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 sm:px-10 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-black text-sm sm:text-lg uppercase tracking-tighter italic flex items-center justify-center transition active:scale-95 shadow-lg">
                    <span class="text-xs sm:text-lg">Lanjut</span>
                    <i class='bx bx-right-arrow-alt text-xl sm:text-2xl sm:ml-2'></i>
                </button>
            </div>
        </div>
    </div>

    <!-- MathJax trigger -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                if (window.MathJax) {
                    MathJax.typesetPromise();
                }
            });
        });
    </script>
</x-app-layout>
