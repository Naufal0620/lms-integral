<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tighter italic">MASUK AKUN</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Selamat datang kembali, Mahasiswa!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="email@anda.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Kata Sandi" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md border-2 border-slate-200 dark:border-white/10 text-blue-600 shadow-sm focus:ring-blue-500 bg-slate-50 dark:bg-slate-900" name="remember">
                <span class="ms-2 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest group-hover:text-blue-600 transition">{{ __('Ingat Saya') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-500 underline uppercase tracking-widest" href="{{ route('password.request') }}">
                    {{ __('Lupa Sandi?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full text-lg">
                {{ __('Masuk Sekarang') }}
            </x-primary-button>
        </div>
        
        <div class="text-center pt-4">
            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </form>
</x-guest-layout>
