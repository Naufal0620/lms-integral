<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tighter italic">PEMULIHAN AKSES</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium px-4">Lupa sandi kuno? Kami akan mengirimkan gulungan pemulihan ke emailmu.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email Terdaftar" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="email@quest.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Kirim Gulungan Pemulihan') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('login') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline uppercase tracking-widest">
                Kembali ke Gerbang Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
