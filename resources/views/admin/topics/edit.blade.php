<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.topics.index') }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Edit <span class="text-blue-600">Wilayah</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Modifikasi tantangan di {{ $topic->title }}.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 p-8 md:p-12 relative group">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i class='bx bx-edit text-9xl'></i>
                </div>

                <form method="POST" action="{{ route('admin.topics.update', $topic) }}" class="space-y-8 relative z-10">
                    @csrf
                    @method('PATCH')

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Nama Wilayah')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $topic->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Narasi Wilayah')" />
                        <textarea id="description" name="description" rows="4" class="block mt-1 w-full bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 focus:border-blue-500 focus:ring-0 rounded-2xl px-4 py-3 text-slate-900 dark:text-white transition duration-200 font-bold">{{ old('description', $topic->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Order -->
                        <div>
                            <x-input-label for="order" :value="__('Urutan Kemunculan')" />
                            <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $topic->order)" required />
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                        </div>

                        <!-- Required Level -->
                        <div>
                            <x-input-label for="required_level" :value="__('Level Minimal')" />
                            <x-text-input id="required_level" class="block mt-1 w-full" type="number" name="required_level" :value="old('required_level', $topic->required_level)" required />
                            <x-input-error :messages="$errors->get('required_level')" class="mt-2" />
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
