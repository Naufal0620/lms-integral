<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.topics.index') }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-slate-900 dark:text-white leading-tight tracking-tight uppercase italic">
                    Kelola <span class="text-red-600">Pertanyaan</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Kuis: {{ $quiz->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Form Tambah Pertanyaan -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-[#1e293b] rounded-[2.5rem] p-8 shadow-2xl border-2 border-slate-100 dark:border-white/5 sticky top-32">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white mb-6 uppercase tracking-tighter italic flex items-center">
                            <i class='bx bx-plus-circle me-2 text-blue-600'></i> Tambah Soal
                        </h3>
                        
                        <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="question_text" value="Teks Pertanyaan" />
                                <textarea id="question_text" name="question_text" required rows="3" class="w-full rounded-2xl border-2 border-slate-100 dark:border-white/5 dark:bg-slate-900 text-sm focus:border-blue-500 focus:ring-0 dark:text-white font-bold transition-all" placeholder="Masukkan rumus atau pertanyaan..."></textarea>
                            </div>

                            <div>
                                <x-input-label for="points" value="Poin XP" />
                                <x-text-input id="points" name="points" type="number" value="10" required class="w-full" />
                            </div>

                            <div class="space-y-4">
                                <x-input-label value="Opsi Jawaban" />
                                @for($i = 0; $i < 4; $i++)
                                    <div class="flex items-center space-x-3 group/opt">
                                        <input type="radio" name="correct_option" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-2 border-slate-300 focus:ring-blue-500 bg-white dark:bg-slate-800">
                                        <input type="text" name="options[]" placeholder="Opsi {{ $i+1 }}" required class="flex-1 rounded-xl border-2 border-slate-100 dark:border-white/5 dark:bg-slate-900 text-sm dark:text-white font-medium group-hover/opt:border-blue-400 transition-all">
                                    </div>
                                @endfor
                            </div>

                            <button type="submit" class="rpg-button w-full bg-blue-600 text-white font-black py-4 rounded-2xl uppercase tracking-tighter italic shadow-lg">
                                Simpan Pertanyaan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Daftar Pertanyaan -->
                <div class="lg:col-span-2 space-y-6">
                    @if(session('success'))
                        <div class="bg-emerald-500/10 border-2 border-emerald-500/20 text-emerald-600 dark:text-emerald-400 p-5 rounded-2xl shadow-xl flex items-center mb-6">
                            <i class='bx bx-check-circle text-2xl mr-4'></i>
                            <p class="font-black uppercase tracking-tighter">{{ session('success') }}</p>
                        </div>
                    @endif

                    @forelse($quiz->questions as $question)
                        <div class="bg-white dark:bg-[#1e293b] rounded-[2.5rem] p-8 shadow-xl border-2 border-slate-100 dark:border-white/5 relative group">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center">
                                    <span class="bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-slate-400 font-black px-4 py-1.5 rounded-xl text-xs mr-4 uppercase tracking-widest italic shadow-sm border border-slate-200/50 dark:border-white/5">Soal #{{ $loop->iteration }}</span>
                                    <h4 class="text-lg font-black text-slate-800 dark:text-white tracking-tight italic">{{ $question->question_text }}</h4>
                                </div>
                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-slate-50 dark:bg-white/5 text-slate-300 hover:text-red-500 transition-all rounded-xl">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($question->options as $option)
                                    <div class="flex items-center p-4 rounded-2xl border-2 {{ $option->is_correct ? 'border-emerald-500/30 bg-emerald-50/50 dark:bg-emerald-500/10' : 'border-slate-50 dark:border-white/5' }} transition-all">
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center mr-4 {{ $option->is_correct ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-slate-200 dark:bg-slate-700 text-slate-400' }}">
                                            @if($option->is_correct)
                                                <i class='bx bx-check text-xl'></i>
                                            @else
                                                <i class='bx bx-circle text-xs'></i>
                                            @endif
                                        </div>
                                        <span class="text-sm {{ $option->is_correct ? 'font-black text-emerald-700 dark:text-emerald-400 uppercase italic' : 'font-bold text-slate-500 dark:text-slate-400' }}">
                                            {{ $option->option_text }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="bg-blue-50 dark:bg-blue-900/10 border-4 border-dashed border-blue-200 dark:border-blue-900/30 rounded-[3rem] p-20 text-center">
                            <i class='bx bx-list-plus text-7xl text-blue-200 dark:text-blue-900/50 mb-6'></i>
                            <h3 class="text-2xl font-black text-blue-900 dark:text-blue-400 uppercase italic tracking-tighter leading-none">Belum Ada Tantangan</h3>
                            <p class="text-blue-600/60 dark:text-blue-400/40 text-sm mt-4 font-bold uppercase tracking-widest">Gunakan form di samping untuk mulai membuat soal.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
