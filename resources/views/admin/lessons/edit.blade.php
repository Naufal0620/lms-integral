<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.topics.show', $lesson->topic_id) }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Edit <span class="text-blue-600">Stage</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Perbarui materi pahlawan.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 p-8 md:p-12 relative">
                <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}" class="space-y-8">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="topic_id" value="{{ $lesson->topic_id }}">

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Judul Materi')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $lesson->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Order -->
                        <div>
                            <x-input-label for="order" :value="__('Urutan Stage')" />
                            <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $lesson->order)" required />
                        </div>

                        <!-- XP Reward -->
                        <div>
                            <x-input-label for="xp_reward" :value="__('Reward XP')" />
                            <x-text-input id="xp_reward" class="block mt-1 w-full" type="number" name="xp_reward" :value="old('xp_reward', $lesson->xp_reward)" required />
                        </div>

                        <!-- Video URL -->
                        <div>
                            <x-input-label for="video_url" :value="__('YouTube URL (Opsional)')" />
                            <x-text-input id="video_url" class="block mt-1 w-full" type="url" name="video_url" :value="old('video_url', $lesson->video_url)" placeholder="https://youtube.com/..." />
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="rpg-button w-full bg-blue-600 text-white font-black py-5 rounded-2xl uppercase tracking-tighter italic text-xl shadow-xl shadow-blue-500/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
