<x-app-layout>
    <div class="h-[calc(100vh-64px)] h-[calc(100dvh-64px)] overflow-hidden bg-slate-50 dark:bg-[#0f172a]" x-data="{ 
        currentSlide: 0, 
        totalSlides: {{ $quiz->questions->count() }},
        answers: {},
        nextSlide() { if(this.currentSlide < this.totalSlides - 1) this.currentSlide++; },
        prevSlide() { if(this.currentSlide > 0) this.currentSlide--; }
    }">
        <div class="max-w-4xl mx-auto h-full flex flex-col px-3 sm:px-6 lg:px-8">
            
            <div class="py-3 sm:py-4 flex items-center justify-between border-b border-slate-100 dark:border-white/5">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ $quiz->lesson_id ? route('topics.show', $quiz->lesson->topic_id) : route('topics.show', $quiz->topic_id) }}" class="p-1.5 sm:p-2 bg-white dark:bg-white/5 rounded-xl hover:bg-slate-100 dark:hover:bg-white/10 transition border border-slate-100 dark:border-white/5">
                        <i class='bx bx-x text-xl sm:text-2xl text-slate-500'></i>
                    </a>
                    <div class="min-w-0">
                        <h2 class="font-black text-[10px] sm:text-sm text-slate-900 dark:text-white uppercase italic truncate max-w-[120px] sm:max-w-md">
                            Evaluasi: {{ $quiz->title }}
                        </h2>
                        <div class="flex items-center space-x-1 mt-0.5 overflow-hidden">
                            <template x-for="i in totalSlides">
                                <div class="h-1 rounded-full transition-all duration-300" 
                                     :class="i-1 <= currentSlide ? 'w-3 sm:w-4 bg-amber-500' : 'w-1 sm:w-2 bg-slate-200 dark:bg-slate-800'"></div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="shrink-0">
                    <span class="text-[8px] sm:text-[10px] font-black text-amber-600 dark:text-amber-400 uppercase tracking-widest bg-amber-50 dark:bg-amber-500/10 px-2 sm:px-3 py-1 rounded-full border border-amber-100 dark:border-amber-500/20">
                        <span x-text="currentSlide + 1"></span> / <span x-text="totalSlides"></span>
                    </span>
                </div>
            </div>

            <!-- Quiz Slide Container -->
            <div class="flex-grow flex items-center justify-center py-4 sm:py-6 relative overflow-hidden">
                <form id="quiz-form" action="{{ route('quizzes.submit', $quiz) }}" method="POST" class="w-full h-full">
                    @csrf
                    @foreach($quiz->questions as $index => $question)
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
                                    <div class="mb-6 sm:mb-10 text-center">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-600 rounded-xl sm:rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-lg rotate-3">
                                            <span class="text-xl sm:text-2xl font-black text-white italic">#{{ $index + 1 }}</span>
                                        </div>
                                        <h3 class="text-lg sm:text-2xl md:text-3xl font-black text-slate-900 dark:text-white italic leading-tight">
                                            {{ $question->question_text }}
                                        </h3>
                                    </div>

                                    <div class="grid gap-3 sm:gap-4 max-w-2xl mx-auto w-full pb-8">
                                        @foreach($question->options as $option)
                                            <label class="relative flex items-center p-4 sm:p-6 rounded-xl sm:rounded-2xl border-2 cursor-pointer transition-all group overflow-hidden"
                                                :class="answers['{{ $question->id }}'] == '{{ $option->id }}' ? 'bg-blue-50 dark:bg-blue-500/10 border-blue-500 shadow-md' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-white/5 active:border-slate-300'">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" 
                                                    x-model="answers['{{ $question->id }}']"
                                                    required class="hidden">
                                                <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 flex items-center justify-center mr-3 sm:mr-4 transition-colors shrink-0"
                                                    :class="answers['{{ $question->id }}'] == '{{ $option->id }}' ? 'border-blue-500 bg-blue-500' : 'border-slate-300'">
                                                    <div x-show="answers['{{ $question->id }}'] == '{{ $option->id }}'" class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full"></div>
                                                </div>
                                                <span class="text-sm sm:text-lg font-bold transition-colors"
                                                    :class="answers['{{ $question->id }}'] == '{{ $option->id }}' ? 'text-blue-700 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300'">
                                                    {{ $option->option_text }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>
            </div>

            <!-- Quiz Navigation Bar -->
            <div class="py-4 sm:py-6 flex items-center justify-between gap-3 sm:gap-4">
                <button @click="prevSlide" 
                        class="px-4 py-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-slate-200 dark:border-white/5 text-slate-500 dark:text-slate-400 font-black uppercase tracking-tighter italic flex items-center transition active:scale-95 disabled:opacity-0"
                        :disabled="currentSlide === 0">
                    <i class='bx bx-left-arrow-alt text-xl sm:text-2xl sm:mr-2'></i>
                    <span class="hidden sm:inline">Kembali</span>
                </button>

                <div x-show="currentSlide === totalSlides - 1" class="flex-grow sm:flex-grow-0">
                    <button type="submit" form="quiz-form" class="w-full bg-emerald-600 text-white px-6 sm:px-12 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-black text-sm sm:text-lg uppercase tracking-tighter italic flex items-center justify-center space-x-2 transition active:scale-95 shadow-lg shadow-emerald-500/20">
                        <span class="whitespace-nowrap text-xs sm:text-lg">Kirim Jawaban</span>
                        <i class='bx bx-send text-xl sm:text-2xl'></i>
                    </button>
                </div>

                <button @click="nextSlide" 
                        x-show="currentSlide < totalSlides - 1"
                        class="flex-grow sm:flex-grow-0 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 sm:px-10 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-black text-sm sm:text-lg uppercase tracking-tighter italic flex items-center justify-center transition active:scale-95 shadow-lg">
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
