@props([
    'title',
    'value',
    'subtitle' => null,
    'icon' => 'analytics',
    'badge' => null,
    'badgeType' => 'info', // success, info, warning
    'color' => 'primary'   // primary, secondary, tertiary, emerald
])

@php
    $bgIcon = match($color) {
        'secondary' => 'bg-rose-500/15 text-rose-500 dark:text-rose-400',
        'tertiary' => 'bg-red-700/15 text-red-600 dark:text-tertiary',
        'emerald' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400',
        default => 'bg-red-500/15 text-red-600 dark:text-red-400',
    };
@endphp

<div class="relative overflow-hidden rounded-2xl p-5 glass-panel glass-card-hover flex flex-col justify-between group">
    <div class="flex items-start justify-between">
        <div class="p-3 rounded-xl {{ $bgIcon }} transition-transform group-hover:scale-105">
            <span class="material-symbols-outlined text-[24px]">{{ $icon }}</span>
        </div>
        @if($badge)
            <span class="inline-flex items-center text-[11px] font-semibold px-2.5 py-0.5 rounded-full {{
                $badgeType === 'success' ? 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400' :
                ($badgeType === 'warning' ? 'bg-amber-500/15 text-amber-600 dark:text-amber-400' : 'bg-red-500/15 text-red-600 dark:text-rose-400')
            }}">
                {{ $badge }}
            </span>
        @endif
    </div>

    <div class="mt-4" x-data="{ count: 0, target: {{ (int)$value }} }"
         x-init="
            let current = 0;
            let step = Math.max(1, Math.floor(target / 15));
            let timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    count = target;
                    clearInterval(timer);
                } else {
                    count = current;
                }
            }, 20);
         ">
        <span class="text-xs font-medium text-slate-500 dark:text-on-surface-variant">{{ $title }}</span>
        <div class="flex items-baseline gap-2 mt-1">
            <span class="font-headline text-3xl font-bold text-slate-800 dark:text-on-surface" x-text="count">
                {{ $value }}
            </span>
            @if($subtitle)
                <span class="text-xs text-slate-400 dark:text-on-surface-variant">{{ $subtitle }}</span>
            @endif
        </div>
    </div>
</div>
