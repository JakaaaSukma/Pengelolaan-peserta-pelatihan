<aside class="hidden md:flex fixed left-0 top-0 h-full w-72 bg-white/85 dark:bg-surface-container-low/90 border-r border-slate-200/50 dark:border-white/10 z-40 flex-col justify-between py-6 px-4 shadow-sm">
    <div class="flex flex-col gap-6">
        <!-- Brand Title & Icon -->
        <a href="{{ Auth::user()->isTrainer() ? route('trainer.dashboard') : route('member.dashboard') }}" class="flex items-center gap-3 px-3 py-2 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 to-rose-700 flex items-center justify-center text-white shadow-md shadow-red-600/30 group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined text-[24px]">trending_up</span>
            </div>
            <div class="flex flex-col">
                <span class="font-headline text-lg font-bold tracking-tight text-slate-800 dark:text-on-surface">TalentTrack</span>
                <span class="font-sans text-[11px] font-semibold text-red-600 dark:text-tertiary tracking-wider uppercase">Career Monitoring</span>
            </div>
        </a>

        <!-- Navigation Menus -->
        <nav class="flex flex-col gap-1.5">
            @if(Auth::user()->isMember())
                <!-- Member Navigation -->
                <a href="{{ route('member.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('member.dashboard') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">dashboard</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('member.buku-saku') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('member.buku-saku') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-rose-500 dark:text-tertiary group-hover:scale-110 transition-transform">menu_book</span>
                    <span>Buku Saku Digital</span>
                </a>

                <a href="{{ route('member.jadwal-pelatihan') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('member.jadwal-pelatihan') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-red-500 dark:text-rose-400 group-hover:scale-110 transition-transform">school</span>
                    <span>Jadwal Pelatihan</span>
                </a>

                <a href="{{ route('member.jadwal-interview') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('member.jadwal-interview') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-rose-600 dark:text-rose-300 group-hover:scale-110 transition-transform">contact_mail</span>
                    <span>Jadwal Interview</span>
                </a>

                <a href="{{ route('member.profile') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('member.profile') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-red-500 dark:text-rose-400 group-hover:scale-110 transition-transform">manage_accounts</span>
                    <span>Profil Akun</span>
                </a>
            @else
                <!-- Trainer Navigation -->
                <a href="{{ route('trainer.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('trainer.dashboard') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">dashboard</span>
                    <span>Dashboard Trainer</span>
                </a>

                <a href="{{ route('trainer.members.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('trainer.members.*') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-red-500 dark:text-rose-400 group-hover:scale-110 transition-transform">group</span>
                    <span>Daftar Member</span>
                </a>

                <a href="{{ route('trainer.trainings.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('trainer.trainings.*') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-rose-500 dark:text-red-400 group-hover:scale-110 transition-transform">calendar_month</span>
                    <span>Kelola Pelatihan</span>
                </a>

                <a href="{{ route('trainer.interviews.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('trainer.interviews.*') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-red-600 dark:text-tertiary group-hover:scale-110 transition-transform">fact_check</span>
                    <span>Kelola Interview</span>
                </a>

                <a href="{{ route('trainer.profile') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-150 group {{ request()->routeIs('trainer.profile') ? 'bg-red-500/15 text-red-600 dark:text-red-400 font-semibold border-l-4 border-red-600' : 'text-slate-600 dark:text-on-surface-variant hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400' }}">
                    <span class="material-symbols-outlined text-[22px] text-rose-500 dark:text-rose-400 group-hover:scale-110 transition-transform">manage_accounts</span>
                    <span>Profil Akun</span>
                </a>
            @endif
        </nav>
    </div>

    <!-- Bottom Widget / Status Card in Sidebar -->
    <div class="flex flex-col gap-4">
        @if(Auth::user()->isMember())
            @php
                $profile = Auth::user()->profile;
                $pct = $profile ? $profile->progress_percentage : 16;
                $stageName = $profile ? ucfirst(str_replace('_', ' ', $profile->tahap_saat_ini)) : 'Pendaftaran';
            @endphp
            <div class="p-4 rounded-2xl bg-red-500/10 dark:bg-surface-container/70 border border-red-500/20 dark:border-white/10 flex flex-col gap-2.5 shadow-sm">
                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-on-surface-variant">
                    <span class="font-medium">Tahap Saat Ini</span>
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                </div>
                <div class="font-headline font-bold text-sm text-slate-800 dark:text-on-surface truncate">
                    {{ $stageName }}
                </div>
                <div class="w-full bg-slate-200 dark:bg-surface-variant h-2 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-rose-500 h-full rounded-full transition-all duration-300" style="width: {{ $pct }}%"></div>
                </div>
                <div class="flex justify-between text-[11px] font-semibold text-slate-500 dark:text-on-surface-variant">
                    <span class="text-red-600 dark:text-rose-400">Progres</span>
                    <span>{{ $pct }}% Selesai</span>
                </div>
            </div>
        @else
            <div class="p-4 rounded-2xl bg-gradient-to-br from-red-600/15 to-rose-700/15 border border-red-500/20 dark:border-white/10 flex flex-col gap-2">
                <div class="flex items-center gap-2 text-red-600 dark:text-rose-400 font-semibold text-xs uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Trainer Access</span>
                </div>
                <p class="text-xs text-slate-600 dark:text-on-surface-variant leading-relaxed">
                    Pemantauan kurasi peserta dan akselerasi karir industri aktif.
                </p>
            </div>
        @endif

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-500/10 transition-colors text-xs font-semibold">
                <span class="material-symbols-outlined text-[18px]">logout</span>
                <span>Keluar Akun</span>
            </button>
        </form>
    </div>
</aside>
