@props(['stages', 'currentStage' => 'pendaftaran'])

<div class="w-full overflow-x-auto pb-4 pt-2">
    <div class="min-w-[720px] flex items-center justify-between relative px-6">
        <!-- Connecting Line Background -->
        <div class="absolute left-12 right-12 top-6 h-1 bg-slate-200 dark:bg-surface-variant z-0 rounded-full"></div>

        @php
            $stagesList = is_array($stages) ? $stages : [];
            $completedCount = 0;
            foreach ($stagesList as $st) {
                if (($st['status'] ?? '') === 'selesai') $completedCount++;
            }
            $pctLine = count($stagesList) > 1 ? min(100, ($completedCount / (count($stagesList) - 1)) * 100) : 0;
        @endphp

        <!-- Connecting Line Active (Red Gradient with Smooth Expansion Motion) -->
        <div class="absolute left-12 top-6 h-1 bg-gradient-to-r from-red-600 via-rose-500 to-red-400 z-0 rounded-full transition-all duration-1000 ease-out"
             x-data="{ activeW: '0%' }"
             x-init="setTimeout(() => activeW = 'calc({{ $pctLine }}% - 3rem)', 250)"
             :style="`width: ${activeW}`"></div>

        @foreach($stagesList as $stage)
            @php
                $status = $stage['status'] ?? 'belum_mulai';
                $isCurrent = $stage['is_current'] ?? false;
            @endphp
            <div class="flex flex-col items-center relative z-10 group">
                <!-- Circle Node -->
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-300 transform group-hover:scale-110 {{
                    $status === 'selesai'
                        ? 'bg-gradient-to-br from-red-600 to-rose-700 text-white shadow-md shadow-red-600/30'
                        : ($isCurrent
                            ? 'bg-gradient-to-br from-red-500 to-rose-600 text-white ring-4 ring-red-500/30 shadow-lg shadow-red-500/40 scale-105'
                            : 'bg-white dark:bg-surface-container-high border-2 border-slate-200 dark:border-outline-variant/60 text-slate-400 dark:text-outline')
                }}">
                    <span class="material-symbols-outlined text-[22px]">
                        {{ $status === 'selesai' ? 'check' : ($stage['icon'] ?? 'circle') }}
                    </span>
                </div>

                <!-- Label -->
                <div class="flex flex-col items-center mt-3 text-center max-w-[110px]">
                    <span class="font-headline text-xs font-semibold {{ $isCurrent ? 'text-red-600 dark:text-rose-400 font-bold' : ($status === 'selesai' ? 'text-slate-800 dark:text-on-surface' : 'text-slate-400 dark:text-outline') }}">
                        {{ $stage['label'] }}
                    </span>
                    <span class="text-[10px] uppercase font-semibold mt-0.5 px-2 py-0.5 rounded-full {{
                        $status === 'selesai'
                            ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400'
                            : ($isCurrent
                                ? 'bg-red-500/15 text-red-600 dark:text-rose-400'
                                : 'bg-slate-100 dark:bg-surface-variant text-slate-400 dark:text-outline')
                    }}">
                        {{ $status === 'selesai' ? 'Selesai' : ($isCurrent ? 'Berjalan' : 'Belum Mulai') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
