<header class="fixed top-0 left-0 right-0 h-16 md:h-18 bg-white/90 dark:bg-surface-container-low/95 border-b border-slate-200/50 dark:border-white/10 z-40 px-4 sm:px-6 lg:px-8 shadow-sm backdrop-blur-md"
        x-data="{ mobileMenu: false }">
    <div class="max-w-[1440px] mx-auto h-full flex items-center justify-between gap-4">
        
        <!-- Left: Brand Logo & Title -->
        <a href="{{ Auth::user()->isTrainer() ? route('trainer.dashboard') : route('member.dashboard') }}" 
           class="flex items-center gap-3 py-1 group shrink-0">
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-red-600 to-rose-700 flex items-center justify-center text-white shadow-md shadow-red-600/30 group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined text-[20px] sm:text-[22px]">trending_up</span>
            </div>
            <div class="flex flex-col">
                <span class="font-headline text-base sm:text-lg font-bold tracking-tight text-slate-800 dark:text-on-surface leading-tight">TalentTrack</span>
                <span class="font-sans text-[10px] font-semibold text-red-600 dark:text-tertiary tracking-wider uppercase leading-none">Career Monitoring</span>
            </div>
        </a>

        <!-- Center: Top Navigation Bar Options (Pilihan Halaman di Atas) -->
        <nav class="hidden md:flex items-center gap-1 xl:gap-2">
            @if(Auth::user()->isMember())
                <!-- Member Navigation Links -->
                <a href="{{ route('member.dashboard') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('member.dashboard') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">dashboard</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('member.modules.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('member.modules.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">library_books</span>
                    <span>Modul Pelatihan</span>
                </a>

                <a href="{{ route('member.buku-saku') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('member.buku-saku') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">menu_book</span>
                    <span>Buku Saku Digital</span>
                </a>

                <a href="{{ route('member.jadwal-pelatihan') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('member.jadwal-pelatihan') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">school</span>
                    <span>Jadwal Pelatihan</span>
                </a>

                <a href="{{ route('member.jadwal-interview') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('member.jadwal-interview') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">contact_mail</span>
                    <span>Jadwal Interview</span>
                </a>

                <a href="{{ route('member.profile') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('member.profile') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">manage_accounts</span>
                    <span>Profil Akun</span>
                </a>
            @else
                <!-- Trainer Navigation Links -->
                <a href="{{ route('trainer.dashboard') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('trainer.dashboard') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">dashboard</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('trainer.members.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('trainer.members.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">group</span>
                    <span>Daftar Member</span>
                </a>

                <a href="{{ route('trainer.trainings.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('trainer.trainings.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">calendar_month</span>
                    <span>Kelola Pelatihan</span>
                </a>

                <a href="{{ route('trainer.modules.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('trainer.modules.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">library_books</span>
                    <span>Modul Pelatihan</span>
                </a>

                <a href="{{ route('trainer.interviews.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('trainer.interviews.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">fact_check</span>
                    <span>Kelola Interview</span>
                </a>

                <a href="{{ route('trainer.profile') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold transition-all duration-150 {{ request()->routeIs('trainer.profile') ? 'bg-red-600 text-white shadow-md shadow-red-600/30' : 'text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10' }}">
                    <span class="material-symbols-outlined text-[19px]">manage_accounts</span>
                    <span>Profil Akun</span>
                </a>
            @endif
        </nav>

        <!-- Right: Theme Toggle, Notifications, User Menu & Mobile Trigger -->
        <div class="flex items-center gap-2 sm:gap-3">
            <!-- Theme Toggle (Dark / Light) -->
            <button @click="$store.theme.toggle()"
                    class="p-2 sm:p-2.5 rounded-xl bg-slate-100 dark:bg-surface-container/70 border border-slate-200/40 dark:border-white/5 text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 transition-all shadow-sm"
                    title="Beralih Tema Terang / Gelap"
                    aria-label="Toggle Dark/Light Mode">
                <span class="material-symbols-outlined text-[19px] dark:hidden">dark_mode</span>
                <span class="material-symbols-outlined text-[19px] hidden dark:inline">light_mode</span>
            </button>

            <!-- Notification Bell Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="relative p-2 sm:p-2.5 rounded-xl bg-slate-100 dark:bg-surface-container/70 border border-slate-200/40 dark:border-white/5 text-slate-600 dark:text-on-surface-variant hover:text-red-600 dark:hover:text-red-400 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[19px]">notifications</span>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-600 rounded-full ring-2 ring-white dark:ring-surface"></span>
                    @endif
                </button>

                <!-- Notifications Flyout -->
                <div x-show="open"
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     style="display: none;"
                     class="absolute right-0 mt-2 w-80 md:w-96 rounded-2xl glass-modal p-4 z-50 shadow-2xl">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200/50 dark:border-white/10 mb-3">
                        <span class="font-headline font-bold text-sm text-slate-800 dark:text-on-surface">Notifikasi</span>
                        <span class="text-xs text-red-600 dark:text-rose-400 font-medium">{{ Auth::user()->unreadNotifications->count() }} Baru</span>
                    </div>
                    <div class="flex flex-col gap-2.5 max-h-72 overflow-y-auto">
                        @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notif)
                            <div class="p-3 rounded-xl bg-slate-50 dark:bg-surface-container-high/50 hover:bg-red-500/10 transition-colors">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $notif->is_read ? 'bg-slate-400' : 'bg-red-600' }}"></span>
                                    <span class="font-semibold text-xs text-slate-800 dark:text-on-surface truncate">{{ $notif->judul }}</span>
                                    <span class="text-[10px] text-slate-400 ml-auto">{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-slate-600 dark:text-on-surface-variant leading-relaxed">{{ $notif->pesan }}</p>
                            </div>
                        @empty
                            <div class="text-center py-6 text-slate-400 text-xs">
                                Tidak ada notifikasi baru saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- User Profile Interactive Dropdown -->
            <div class="relative" x-data="{ userMenu: false }">
                <button @click="userMenu = !userMenu"
                        class="flex items-center gap-2 sm:gap-3 pl-2 py-1 pr-2 rounded-2xl hover:bg-red-500/10 transition-all border-l border-slate-200/60 dark:border-white/10">
                    <div class="relative">
                        <img src="{{ Auth::user()->avatar_url }}"
                             alt="{{ Auth::user()->name }}"
                             class="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover ring-2 ring-red-500/40">
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-white dark:ring-surface"></span>
                    </div>
                    <div class="hidden xl:flex flex-col text-left">
                        <span class="font-headline text-xs font-semibold text-slate-800 dark:text-on-surface leading-tight max-w-[120px] truncate">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="text-[10px] text-slate-500 dark:text-on-surface-variant capitalize">
                            {{ Auth::user()->role === 'trainer' ? 'Trainer Vokasi' : 'Peserta' }}
                        </span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 text-[18px]">expand_more</span>
                </button>

                <!-- User Menu Flyout -->
                <div x-show="userMenu"
                     @click.outside="userMenu = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     style="display: none;"
                     class="absolute right-0 mt-2 w-56 rounded-2xl glass-modal p-2 z-50 shadow-2xl">
                    <div class="px-3 py-2 border-b border-slate-200/50 dark:border-white/10 mb-1">
                        <span class="text-xs font-bold text-slate-800 dark:text-on-surface block truncate">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-slate-400 block truncate">{{ Auth::user()->email }}</span>
                    </div>

                    <a href="{{ route('profile') }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-on-surface hover:bg-red-500/15 hover:text-red-600 dark:hover:text-red-400 transition-all">
                        <span class="material-symbols-outlined text-[18px] text-red-600 dark:text-rose-400">manage_accounts</span>
                        <span>Profil Akun Saya</span>
                    </a>

                    @if(Auth::user()->isMember())
                        <a href="{{ route('member.buku-saku') }}"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-on-surface hover:bg-red-500/15 hover:text-red-600 dark:hover:text-red-400 transition-all">
                            <span class="material-symbols-outlined text-[18px] text-rose-500">menu_book</span>
                            <span>Buku Saku Digital</span>
                        </a>
                    @endif

                    <div class="my-1 border-t border-slate-200/50 dark:border-white/10"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-500/10 transition-all text-left">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            <span>Keluar Akun</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Hamburger Button -->
            <button @click="mobileMenu = !mobileMenu"
                    class="md:hidden p-2 rounded-xl bg-slate-100 dark:bg-surface-container/70 border border-slate-200/40 dark:border-white/5 text-slate-700 dark:text-on-surface hover:text-red-600">
                <span class="material-symbols-outlined text-[22px]" x-text="mobileMenu ? 'close' : 'menu'">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Slide-Down Dropdown Menu -->
    <div x-show="mobileMenu"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         style="display: none;"
         class="md:hidden border-t border-slate-200/50 dark:border-white/10 bg-white/95 dark:bg-surface-container-low/95 px-4 py-3 space-y-1 shadow-xl">
        @if(Auth::user()->isMember())
            <a href="{{ route('member.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('member.dashboard') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('member.modules.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('member.modules.*') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">library_books</span>
                <span>Modul Pelatihan</span>
            </a>
            <a href="{{ route('member.buku-saku') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('member.buku-saku') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">menu_book</span>
                <span>Buku Saku Digital</span>
            </a>
            <a href="{{ route('member.jadwal-pelatihan') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('member.jadwal-pelatihan') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">school</span>
                <span>Jadwal Pelatihan</span>
            </a>
            <a href="{{ route('member.jadwal-interview') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('member.jadwal-interview') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">contact_mail</span>
                <span>Jadwal Interview</span>
            </a>
            <a href="{{ route('member.profile') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('member.profile') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                <span>Profil Akun</span>
            </a>
        @else
            <a href="{{ route('trainer.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('trainer.dashboard') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('trainer.members.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('trainer.members.*') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">group</span>
                <span>Daftar Member</span>
            </a>
            <a href="{{ route('trainer.trainings.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('trainer.trainings.*') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                <span>Kelola Pelatihan</span>
            </a>
            <a href="{{ route('trainer.modules.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('trainer.modules.*') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">library_books</span>
                <span>Modul Pelatihan</span>
            </a>
            <a href="{{ route('trainer.interviews.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('trainer.interviews.*') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">fact_check</span>
                <span>Kelola Interview</span>
            </a>
            <a href="{{ route('trainer.profile') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('trainer.profile') ? 'bg-red-600 text-white' : 'text-slate-700 dark:text-on-surface hover:bg-red-500/10' }}">
                <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                <span>Profil Akun</span>
            </a>
        @endif
    </div>
</header>