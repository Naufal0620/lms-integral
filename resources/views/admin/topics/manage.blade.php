<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.topics.index') }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Kelola <span class="text-blue-600">Konten</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Materi & Evaluasi untuk: {{ $topic->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <!-- Lessons Section -->
            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 p-8 md:p-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
                    <div class="flex items-center">
                        <i class='bx bx-book-alt me-3 text-blue-600 text-3xl'></i>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter italic">Daftar Materi</h3>
                    </div>
                    <a href="{{ route('admin.lessons.create', ['topic_id' => $topic->id]) }}" class="rpg-button bg-blue-600 text-white text-[10px] font-black uppercase px-6 py-3 rounded-xl shadow-lg shadow-blue-500/20 flex items-center italic tracking-widest">
                        <i class='bx bx-plus me-1'></i> Tambah Materi
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($topic->lessons as $lesson)
                        <div class="flex flex-col p-6 bg-slate-50 dark:bg-black/20 rounded-3xl border-2 border-transparent hover:border-blue-500/30 transition-all group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 font-black rounded-xl flex items-center justify-center mr-6 text-sm shadow-sm">{{ $lesson->order }}</span>
                                    <div>
                                        <h4 class="font-black text-slate-700 dark:text-slate-200 uppercase tracking-tight">{{ $lesson->title }}</h4>
                                        <div class="flex items-center mt-1 space-x-3">
                                            <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest">{{ $lesson->slides->count() }} Slide</span>
                                            @if($lesson->quiz)
                                                <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest flex items-center">
                                                    <i class='bx bxs-check-circle me-1'></i> Evaluasi Aktif
                                                </span>
                                            @else
                                                <span class="text-[9px] font-black text-amber-500 uppercase tracking-widest flex items-center">
                                                    <i class='bx bxs-error-circle me-1'></i> Belum Ada Evaluasi
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.lessons.slides.index', $lesson) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Kelola Isi Slide">
                                        <i class='bx bx-slideshow text-2xl'></i>
                                    </a>
                                    @if($lesson->quiz)
                                        <a href="{{ route('admin.quizzes.questions.index', $lesson->quiz) }}" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors" title="Kelola Soal Evaluasi">
                                            <i class='bx bx-list-ul text-2xl'></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.quizzes.create', ['lesson_id' => $lesson->id, 'topic_id' => $topic->id]) }}" class="p-2 text-amber-400 hover:text-amber-500 transition-colors" title="Tambah Evaluasi">
                                            <i class='bx bx-plus-circle text-2xl'></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Edit Materi">
                                        <i class='bx bx-edit-alt text-xl'></i>
                                    </a>
                                    <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400 italic font-medium">Belum ada materi di bab ini.</div>
                    @endforelse
                </div>
            </div>

            <!-- Quizzes Section -->
            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 p-8 md:p-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
                    <div class="flex items-center">
                        <i class='bx bx-edit-alt me-3 text-emerald-600 text-3xl'></i>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter italic">Daftar Evaluasi</h3>
                    </div>
                    <a href="{{ route('admin.quizzes.create', ['topic_id' => $topic->id]) }}" class="rpg-button bg-emerald-600 text-white text-[10px] font-black uppercase px-6 py-3 rounded-xl shadow-lg shadow-emerald-500/20 flex items-center italic tracking-widest">
                        <i class='bx bx-plus me-1'></i> Tambah Evaluasi
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($topic->quizzes as $quiz)
                        <div class="flex items-center justify-between p-6 bg-slate-50 dark:bg-black/20 rounded-3xl border-2 border-transparent hover:border-emerald-500/30 transition-all group">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center mr-6">
                                    <i class='bx bx-task text-2xl'></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-700 dark:text-slate-200 uppercase tracking-tight">{{ $quiz->title }}</h4>
                                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">{{ $quiz->questions->count() }} Pertanyaan</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.quizzes.questions.index', $quiz) }}" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors" title="Kelola Pertanyaan">
                                    <i class='bx bx-list-ul text-2xl'></i>
                                </a>
                                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i class='bx bx-edit-alt text-xl'></i>
                                </a>
                                <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Hapus evaluasi ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400 italic font-medium">Belum ada evaluasi di bab ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
