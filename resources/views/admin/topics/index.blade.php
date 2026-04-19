<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Panel <span class="text-blue-600">Admin</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Manajemen Materi Kalkulus.</p>
            </div>
            <a href="{{ route('admin.topics.create') }}" class="rpg-button bg-blue-600 text-white font-black py-3 px-8 rounded-2xl shadow-lg transition-all flex items-center uppercase tracking-widest italic">
                <i class='bx bx-plus-circle me-2 text-xl'></i> Tambah Materi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-8 bg-emerald-500/10 border-2 border-emerald-500/20 text-emerald-600 dark:text-emerald-400 p-5 rounded-2xl shadow-xl flex items-center">
                    <i class='bx bx-check-circle text-2xl mr-4'></i>
                    <p class="font-black uppercase tracking-tighter">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-black/20 border-b border-slate-100 dark:border-white/5">
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Order</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Materi</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Syarat</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Konten</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-white/5">
                            @foreach($topics as $topic)
                                <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-600/5 transition-colors group">
                                    <td class="px-8 py-6">
                                        <span class="bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-400 font-black px-4 py-1.5 rounded-xl text-xs">{{ $topic->order }}</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="font-black text-slate-800 dark:text-white group-hover:text-blue-600 transition-colors uppercase tracking-tight italic">{{ $topic->title }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center text-xs font-black text-blue-600 dark:text-blue-400 uppercase italic">
                                            <i class='bx bxs-up-arrow-circle me-1.5'></i> LVL {{ $topic->required_level }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex flex-col">
                                                <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">{{ $topic->lessons->count() }} Materi</span>
                                                <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">{{ $topic->quizzes->count() }} Evaluasi</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('admin.topics.show', $topic) }}" class="rpg-button bg-blue-600 text-white text-[10px] font-black uppercase px-6 py-2.5 rounded-xl shadow-lg shadow-blue-500/20 hover:scale-105 transition-transform flex items-center">
                                                <i class='bx bx-layer me-2 text-base'></i> Kelola
                                            </a>
                                            <div class="w-px h-8 bg-slate-100 dark:bg-white/5 mx-2"></div>
                                            <a href="{{ route('admin.topics.edit', $topic) }}" class="p-2.5 bg-slate-100 dark:bg-white/5 text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all">
                                                <i class='bx bx-edit-alt text-xl'></i>
                                            </a>
                                            <form action="{{ route('admin.topics.destroy', $topic) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2.5 bg-slate-100 dark:bg-white/5 text-slate-400 hover:text-red-600 rounded-xl transition-all">
                                                    <i class='bx bx-trash text-xl'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
