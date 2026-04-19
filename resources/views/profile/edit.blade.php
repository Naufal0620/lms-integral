<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard') }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Profil <span class="text-blue-600">Mahasiswa</span>
                    ...
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Atur informasi akun dan keamanan Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Informasi Profil -->
            <div class="p-8 sm:p-12 bg-white dark:bg-[#1e293b] shadow-2xl border-2 border-slate-100 dark:border-white/5 rounded-[2.5rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i class='bx bxs-user-detail text-9xl'></i>
                </div>
                <div class="max-w-xl relative z-10">
                    <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tighter italic mb-6 flex items-center">
                        <i class='bx bx-id-card me-3 text-blue-600'></i> Identitas Karakter
                    </h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="p-8 sm:p-12 bg-white dark:bg-[#1e293b] shadow-2xl border-2 border-slate-100 dark:border-white/5 rounded-[2.5rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i class='bx bxs-lock-open text-9xl'></i>
                </div>
                <div class="max-w-xl relative z-10">
                    <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tighter italic mb-6 flex items-center">
                        <i class='bx bx-shield-quarter me-3 text-blue-600'></i> Mantra Keamanan
                    </h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Hapus Akun -->
            <div class="p-8 sm:p-12 bg-white dark:bg-[#1e293b] shadow-2xl border-2 border-red-100 dark:border-red-900/10 rounded-[2.5rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i class='bx bxs-ghost text-9xl text-red-600'></i>
                </div>
                <div class="max-w-xl relative z-10">
                    <h3 class="text-xl font-black text-red-600 uppercase tracking-tighter italic mb-6 flex items-center">
                        <i class='bx bx-error-alt me-3 text-red-600'></i> Gerbang Kehancuran
                    </h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
