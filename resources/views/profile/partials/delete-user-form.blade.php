<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-600 uppercase tracking-tight italic">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rpg-button bg-red-600 text-white px-6 py-3 rounded-xl font-black uppercase tracking-tighter italic shadow-lg shadow-red-500/20"
    >{{ __('Hapus Karakter') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 dark:bg-slate-900">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-900 dark:text-white uppercase italic">
                {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Kata Sandi') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-400 px-6 py-2 rounded-xl font-bold uppercase text-xs mr-3">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-xl font-black uppercase text-xs shadow-lg">
                    {{ __('Hapus Sekarang') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
