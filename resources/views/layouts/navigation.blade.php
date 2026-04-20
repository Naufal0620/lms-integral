<nav x-data="{ open: false }" class="bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-xl border-b border-slate-200 dark:border-white/10 sticky top-0 z-50 transition-colors duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-20 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group">
                        <div class="p-2 bg-blue-600 rounded-xl mr-3 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                            <i class='bx bxs-graduation text-white text-xl'></i>
                        </div>
                        <span class="hidden sm:block text-xl font-black tracking-tighter text-slate-900 dark:text-white uppercase">INTEGRAL<span class="text-blue-600 italic">LEARNING</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold uppercase text-[10px] tracking-widest">
                        {{ __('Materi') }}
                    </x-nav-link>
                    <x-nav-link :href="route('leaderboard')" :active="request()->routeIs('leaderboard')" class="font-bold uppercase text-[10px] tracking-widest">
                        {{ __('Leaderboard') }}
                    </x-nav-link>
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.topics.index')" :active="request()->routeIs('admin.*')" class="font-bold uppercase text-[10px] tracking-widest">
                            {{ __('Panel Admin') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Gamification Stats & Profile -->
            <div class="flex items-center space-x-2 md:space-x-6">
                <!-- Theme Toggle -->
                <button id="theme-toggle" class="p-2 rounded-xl bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 transition text-slate-500 dark:text-slate-400">
                    <i id="theme-toggle-dark-icon" class="bx bx-moon hidden text-xl"></i>
                    <i id="theme-toggle-light-icon" class="bx bx-sun hidden text-xl text-yellow-500"></i>
                </button>

                <!-- XP & Coins -->
                <div class="hidden sm:flex items-center space-x-4 bg-slate-100/50 dark:bg-white/5 px-4 py-2 rounded-2xl border border-slate-200/50 dark:border-white/5">
                    <div class="flex flex-col items-end">
                        <div class="flex items-center space-x-2">
                            <span class="text-[9px] font-black uppercase text-blue-600 dark:text-blue-400 tracking-tighter">Level {{ Auth::user()->level }}</span>
                            <div class="w-24 h-1.5 bg-slate-200 dark:bg-white/10 rounded-full overflow-hidden">
                                @php
                                    $prevLevelXp = pow((Auth::user()->level - 1), 2) * 100;
                                    $nextLevelXp = pow(Auth::user()->level, 2) * 100;
                                    $xpNeeded = max(($nextLevelXp - $prevLevelXp), 1);
                                    $currentProgressXp = Auth::user()->xp - $prevLevelXp;
                                    $progressPercent = min(max(($currentProgressXp / $xpNeeded) * 100, 0), 100);
                                @endphp
                                <div class="bg-blue-600 h-full rounded-full transition-all duration-1000" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        </div>
                        <span class="text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase">{{ Auth::user()->xp }} XP</span>
                    </div>
                    <div class="w-px h-6 bg-slate-200 dark:border-white/5"></div>
                    <div class="flex items-center space-x-1.5">
                        <i class='bx bxs-coin text-amber-500 text-lg'></i>
                        <span class="font-black text-slate-700 dark:text-slate-200 text-xs">{{ number_format(Auth::user()->coins) }}</span>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center p-1 md:p-1.5 bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-xs shadow-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:block ms-3 text-start">
                                    <div class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-tighter">{{ Auth::user()->name }}</div>
                                    <div class="text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ Auth::user()->role }}</div>
                                </div>
                                <div class="ms-2 text-slate-400">
                                    <i class='bx bx-chevron-down text-lg'></i>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="font-bold flex items-center text-xs uppercase tracking-widest">
                                <i class='bx bx-user-circle me-2 text-lg'></i> {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="font-bold flex items-center text-xs uppercase tracking-widest text-red-600 hover:text-red-700">
                                    <i class='bx bx-log-out-circle me-2 text-lg'></i> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center md:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-500 hover:bg-slate-100 dark:hover:bg-white/5 transition duration-150 ease-in-out">
                        <i :class="{'hidden': open, 'block': ! open }" class='bx bx-menu text-2xl'></i>
                        <i :class="{'block': open, 'hidden': ! open }" class='bx bx-x text-2xl'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white dark:bg-[#0f172a] border-b border-slate-200 dark:border-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold uppercase text-[10px] tracking-widest">
                {{ __('Materi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('leaderboard')" :active="request()->routeIs('leaderboard')" class="font-bold uppercase text-[10px] tracking-widest">
                {{ __('Leaderboard') }}
            </x-responsive-nav-link>
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.topics.index')" :active="request()->routeIs('admin.*')" class="font-bold uppercase text-[10px] tracking-widest">
                    {{ __('Panel Admin') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive User Stats -->
        <div class="pt-4 pb-1 border-t border-slate-200 dark:border-white/5">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-black text-sm text-slate-800 dark:text-white uppercase tracking-tighter">{{ Auth::user()->name }}</div>
                    <div class="font-bold text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-widest">LVL {{ Auth::user()->level }} • {{ Auth::user()->xp }} XP</div>
                </div>
                <div class="flex items-center space-x-1.5 bg-amber-400/10 px-3 py-1 rounded-full border border-amber-400/20">
                    <i class='bx bxs-coin text-amber-500'></i>
                    <span class="font-black text-amber-600 text-xs">{{ number_format(Auth::user()->coins) }}</span>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    // Theme Toggle Logic
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    const updateIcons = () => {
        const isDark = document.documentElement.classList.contains('dark');
        if (isDark) {
            darkIcon.classList.add('hidden');
            lightIcon.classList.remove('hidden');
        } else {
            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');
        }
    };

    themeToggleBtn.addEventListener('click', () => {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
        updateIcons();
    });

    updateIcons();
</script>
