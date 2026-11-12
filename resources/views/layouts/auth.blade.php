<!DOCTYPE html>
<html lang="id" class="dark" x-data :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Masuk' }} - {{ config('app.name', 'Monitoring Pelatihan Kerja') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('theme') === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="font-sans text-slate-800 dark:text-on-surface min-h-screen relative overflow-x-hidden flex flex-col justify-between selection:bg-red-600 selection:text-white">

    <!-- Header / Brand & Theme Switcher -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
        <a href="{{ route('login') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 to-rose-700 flex items-center justify-center text-white shadow-md shadow-red-600/30 group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined text-[24px]">trending_up</span>
            </div>
            <div class="flex flex-col">
                <span class="font-headline text-lg font-bold tracking-tight text-slate-800 dark:text-on-surface">TalentTrack</span>
                <span class="text-[11px] font-semibold text-red-600 dark:text-tertiary tracking-wider uppercase">Career Monitoring</span>
            </div>
        </a>

        <button @click="$store.theme.toggle()"
                class="p-2.5 rounded-xl bg-white/80 dark:bg-surface-container/80 border border-slate-200/50 dark:border-white/10 text-slate-600 dark:text-on-surface-variant hover:text-slate-900 dark:hover:text-on-surface shadow-sm transition-all"
                title="Beralih Tema">
            <span class="material-symbols-outlined text-[20px] dark:hidden">dark_mode</span>
            <span class="material-symbols-outlined text-[20px] hidden dark:inline">light_mode</span>
        </button>
    </header>

    <!-- Main Container -->
    <main class="w-full flex-1 flex items-center justify-center p-4 relative z-10">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="w-full text-center py-6 text-xs text-slate-400 dark:text-outline relative z-10">
        &copy; {{ date('Y') }} TalentTrack. Sistem Monitoring Member Pelatihan Kerja & Akselerasi Karir.
    </footer>

    <!-- Global Toast Component -->
    @include('components.toast')

</body>
</html>
