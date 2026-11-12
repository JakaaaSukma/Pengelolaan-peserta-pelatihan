<!DOCTYPE html>
<html lang="id" class="dark" x-data :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Monitoring Pelatihan Kerja') }}</title>

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
<body class="font-sans text-slate-800 dark:text-on-surface min-h-screen relative overflow-x-hidden selection:bg-red-600 selection:text-white pb-20 md:pb-0">

    <!-- Top Navigation Bar (Header) -->
    @include('partials.header')

    <!-- Main Content Area -->
    <div class="flex flex-col min-h-screen relative z-10">
        <!-- Page Main Container -->
        <main class="w-full max-w-[1440px] mx-auto pt-20 md:pt-24 px-4 sm:px-6 lg:px-8 pb-12 flex-1">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-800 dark:text-emerald-200 flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-800 dark:text-rose-200 flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-rose-500">error</span>
                        <span class="font-medium text-sm">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-800 dark:text-red-200 flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-500">info</span>
                        <span class="font-medium text-sm">{{ session('info') }}</span>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            @endif

            <!-- Slot Page Content -->
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    @include('partials.bottom-nav')

    <!-- Global Toast Component -->
    @include('components.toast')

</body>
</html>
