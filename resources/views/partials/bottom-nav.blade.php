<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white/90 dark:bg-surface-container-low/95 border-t border-slate-200/50 dark:border-white/10 z-40 px-1 flex items-center justify-around shadow-lg">
    @if(Auth::user()->isMember())
        <a href="{{ route('member.dashboard') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('member.dashboard') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">dashboard</span>
            <span class="text-[9px]">Dashboard</span>
        </a>

        <a href="{{ route('member.modules.index') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('member.modules.*') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">library_books</span>
            <span class="text-[9px]">Modul</span>
        </a>

        <a href="{{ route('member.buku-saku') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('member.buku-saku') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">menu_book</span>
            <span class="text-[9px]">Buku Saku</span>
        </a>

        <a href="{{ route('member.jadwal-pelatihan') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('member.jadwal-pelatihan') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">school</span>
            <span class="text-[9px]">Pelatihan</span>
        </a>

        <a href="{{ route('member.jadwal-interview') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('member.jadwal-interview') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">contact_mail</span>
            <span class="text-[9px]">Interview</span>
        </a>

        <a href="{{ route('member.profile') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('member.profile') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">person</span>
            <span class="text-[9px]">Profil</span>
        </a>
    @else
        <a href="{{ route('trainer.dashboard') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('trainer.dashboard') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">dashboard</span>
            <span class="text-[9px]">Dashboard</span>
        </a>

        <a href="{{ route('trainer.members.index') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('trainer.members.*') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">group</span>
            <span class="text-[9px]">Member</span>
        </a>

        <a href="{{ route('trainer.trainings.index') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('trainer.trainings.*') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">calendar_month</span>
            <span class="text-[9px]">Pelatihan</span>
        </a>

        <a href="{{ route('trainer.modules.index') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('trainer.modules.*') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">library_books</span>
            <span class="text-[9px]">Modul</span>
        </a>

        <a href="{{ route('trainer.interviews.index') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('trainer.interviews.*') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">fact_check</span>
            <span class="text-[9px]">Interview</span>
        </a>

        <a href="{{ route('trainer.profile') }}"
           class="flex flex-col items-center gap-0.5 py-1 px-1.5 rounded-xl transition-all {{ request()->routeIs('trainer.profile') ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[20px]">person</span>
            <span class="text-[9px]">Profil</span>
        </a>
    @endif
</nav>
