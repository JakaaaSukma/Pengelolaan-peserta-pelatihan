@props(['status'])

@php
    $config = match(strtolower((string)$status)) {
        'hadir', 'lolos', 'ditempatkan' => [
            'label' => ucfirst($status),
            'class' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30',
            'dot' => 'bg-emerald-500'
        ],
        'tidak_hadir', 'tidak_lolos', 'alpa', 'batal' => [
            'label' => str_replace('_', ' ', ucfirst($status)),
            'class' => 'bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30',
            'dot' => 'bg-rose-500'
        ],
        'reschedule', 'izin', 'sakit', 'menunggu_hasil', 'proses' => [
            'label' => str_replace('_', ' ', ucfirst($status)),
            'class' => 'bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30',
            'dot' => 'bg-amber-500'
        ],
        'offline' => [
            'label' => 'Offline (Tatap Muka)',
            'class' => 'bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30',
            'dot' => 'bg-amber-500'
        ],
        'online' => [
            'label' => 'Online (Virtual)',
            'class' => 'bg-red-500/15 text-red-600 dark:text-rose-400 border border-red-500/30',
            'dot' => 'bg-red-500'
        ],
        default => [
            'label' => str_replace('_', ' ', ucfirst($status ?: 'Menunggu')),
            'class' => 'bg-slate-500/15 text-slate-600 dark:text-slate-300 border border-slate-500/30',
            'dot' => 'bg-slate-400'
        ]
    };
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $config['class'] }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
    <span>{{ $config['label'] }}</span>
</span>

