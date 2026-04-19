<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ $lessonId ? route('admin.lessons.slides.index', $lessonId) : route('admin.topics.show', $topicId) }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Tambah <span class="text-red-600">Evaluasi</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Siapkan tantangan ujian untuk mahasiswa.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 p-8 md:p-12 relative group">
                <form method="POST" action="{{ route('admin.quizzes.store') }}" class="space-y-8 relative z-10">
                    @csrf
                    <input type="hidden" name="topic_id" value="{{ $topicId }}">
                    <input type="hidden" name="lesson_id" value="{{ $lessonId }}">

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Nama Evaluasi')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Contoh: Kuis Konsep Dasar" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi Evaluasi')" />
                        <textarea id="description" name="description" rows="3" class="block mt-1 w-full bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 focus:border-blue-500 focus:ring-0 rounded-2xl px-4 py-3 text-slate-900 dark:text-white transition duration-200 font-bold">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Passing Score -->
                    <div>
                        <x-input-label for="passing_score" :value="__('Skor Kelulusan (%)')" />
                        <x-text-input id="passing_score" class="block mt-1 w-full" type="number" name="passing_score" :value="old('passing_score', 80)" min="0" max="100" required />
                        <x-input-error :messages="$errors->get('passing_score')" class="mt-2" />
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="rpg-button w-full bg-red-600 text-white font-black py-5 rounded-2xl uppercase tracking-tighter italic text-xl shadow-xl shadow-red-500/20">
                            Simpan Evaluasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
