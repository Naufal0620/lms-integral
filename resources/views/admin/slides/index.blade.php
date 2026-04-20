<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.topics.show', $lesson->topic_id) }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Kelola <span class="text-blue-600">Slide</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Materi: {{ $lesson->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 p-8 md:p-10">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tighter italic">Alur Slide</h3>
                    <a href="{{ route('admin.lessons.slides.create', $lesson) }}" class="bg-blue-600 text-white text-[10px] font-black uppercase px-6 py-3 rounded-xl shadow-lg shadow-blue-500/20 hover:scale-105 transition-transform flex items-center italic tracking-widest">
                        <i class='bx bx-plus me-1'></i> Tambah Slide
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($slides as $slide)
                        <div class="flex items-center justify-between p-6 bg-slate-50 dark:bg-black/20 rounded-3xl border-2 border-transparent hover:border-blue-500/30 transition-all group">
                            <div class="flex items-center">
                                <span class="w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 font-black rounded-xl flex items-center justify-center mr-6 text-sm shadow-sm">{{ $slide->order }}</span>
                                <div>
                                    <h4 class="font-black text-slate-700 dark:text-slate-200 uppercase tracking-tight">{{ $slide->title ?? 'Tanpa Judul' }}</h4>
                                    <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest {{ $slide->type === 'visualization' ? 'bg-amber-100 text-amber-600' : ($slide->type === 'quiz' ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600') }}">
                                        {{ $slide->type }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.lessons.slides.edit', [$lesson, $slide]) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i class='bx bx-edit-alt text-xl'></i>
                                </a>
                                <form action="{{ route('admin.lessons.slides.destroy', [$lesson, $slide]) }}" method="POST" onsubmit="return confirm('Hapus slide ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400 italic font-medium">Belum ada slide untuk materi ini.</div>
                    @endforelse
                </div>

                <!-- Evaluasi Materi Section -->
                <div class="mt-12 pt-10 border-t-4 border-dashed border-slate-100 dark:border-white/5">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <i class='bx bxs-award me-3 text-emerald-600 text-3xl'></i>
                            <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tighter italic">Evaluasi Akhir Materi</h3>
                        </div>
                    </div>

                    @if($lesson->quiz)
                        <div class="flex items-center justify-between p-6 bg-emerald-50 dark:bg-emerald-500/10 rounded-3xl border-2 border-emerald-500/30 shadow-sm group">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-white dark:bg-slate-800 text-emerald-600 rounded-2xl flex items-center justify-center mr-6 shadow-sm">
                                    <i class='bx bx-task text-2xl'></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-700 dark:text-slate-200 uppercase tracking-tight">{{ $lesson->quiz->title }}</h4>
                                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">{{ $lesson->quiz->questions->count() }} Pertanyaan • Passing Score: {{ $lesson->quiz->passing_score }}%</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.quizzes.questions.index', $lesson->quiz) }}" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors" title="Kelola Soal">
                                    <i class='bx bx-list-ul text-2xl'></i>
                                </a>
                                <a href="{{ route('admin.quizzes.edit', $lesson->quiz) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Edit Pengaturan Kuis">
                                    <i class='bx bx-edit-alt text-xl'></i>
                                </a>
                                <form action="{{ route('admin.quizzes.destroy', $lesson->quiz) }}" method="POST" onsubmit="return confirm('Hapus evaluasi materi ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors" title="Hapus Kuis">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="p-10 border-2 border-dashed border-slate-200 dark:border-white/10 rounded-[2rem] text-center">
                            <i class='bx bx-info-circle text-4xl text-slate-300 mb-4'></i>
                            <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs mb-6 italic">Materi ini belum memiliki evaluasi akhir.</p>
                            <a href="{{ route('admin.quizzes.create', ['lesson_id' => $lesson->id, 'topic_id' => $lesson->topic_id]) }}" class="inline-flex items-center bg-emerald-600 text-white text-[10px] font-black uppercase px-8 py-4 rounded-xl shadow-lg shadow-emerald-500/20 hover:scale-105 transition-transform italic tracking-widest">
                                <i class='bx bx-plus me-1'></i> Tambah Evaluasi Materi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
