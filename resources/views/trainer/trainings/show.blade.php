<x-layouts.app title="Absensi Pelatihan - {{ $training->judul }}">
    <div class="flex flex-col gap-6">
        <!-- Back Navigation -->
        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-on-surface-variant">
            <a href="{{ route('trainer.trainings.index') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Daftar Pelatihan</span>
            </a>
            <span>/</span>
            <span class="text-slate-800 dark:text-on-surface font-semibold">{{ $training->judul }}</span>
        </div>

        <!-- Training Header Info -->
        <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-xl relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <x-badge-status :status="$training->tipe" />
                        <span class="text-xs text-slate-400">Instruktur: <strong>{{ $training->trainer->name }}</strong></span>
                    </div>
                    <h1 class="font-headline text-xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                        {{ $training->judul }}
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant max-w-2xl leading-relaxed">
                        {{ $training->materi }}
                    </p>
                    <div class="flex flex-wrap items-center gap-4 text-xs text-slate-600 dark:text-on-surface-variant pt-2">
                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-primary-container">event</span> {{ $training->tanggal->format('d M Y') }}</span>
                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-primary-container">schedule</span> {{ substr($training->jam_mulai, 0, 5) }} - {{ substr($training->jam_selesai, 0, 5) }} WIB</span>
                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-primary-container">{{ $training->isOffline() ? 'location_on' : 'videocam' }}</span> {{ $training->isOffline() ? ($training->lokasi ?? 'Lab') : ($training->platform ?? 'Meeting') }}</span>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-primary-container/10 border border-primary-container/20 text-center shrink-0">
                    <span class="font-headline text-3xl font-extrabold text-primary-container dark:text-primary block">
                        {{ $training->attendances->count() }}
                    </span>
                    <span class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Peserta</span>
                </div>
            </div>
        </div>

        <!-- Attached Training Modules (PPT / PDF) -->
        @if($training->modules->count() > 0)
            <div class="rounded-3xl p-6 glass-panel shadow-lg space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-headline font-bold text-sm text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-500">library_books</span>
                        <span>Modul & Slide Terlampir untuk Sesi Ini ({{ $training->modules->count() }})</span>
                    </h3>
                    <a href="{{ route('trainer.modules.index') }}" class="text-xs font-semibold text-red-600 dark:text-rose-400 hover:underline flex items-center gap-1">
                        <span>Kelola Semua Modul</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($training->modules as $m)
                        <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-surface-container-high/60 border border-slate-200/50 dark:border-white/5 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 truncate">
                                <span class="material-symbols-outlined text-[20px] {{ $m->isPdf() ? 'text-rose-500' : 'text-amber-500' }}">{{ $m->icon }}</span>
                                <div class="truncate">
                                    <span class="font-bold text-xs text-slate-800 dark:text-on-surface block truncate">{{ $m->judul }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase font-semibold">{{ $m->file_type }} &bull; {{ $m->formatted_file_size }}</span>
                                </div>
                            </div>
                            <a href="{{ route('trainer.modules.download', $m->id) }}" class="p-1.5 rounded-lg bg-red-500/10 text-red-600 hover:bg-red-500/20 shrink-0" title="Unduh Modul">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Attendance & Scoring Mass Form -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-headline text-lg font-bold text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">fact_check</span>
                        <span>Absensi & Nilai Evaluasi Peserta</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant mt-0.5">
                        Perbarui kehadiran, berikan nilai (0-100), dan masukan catatan perkembangan untuk buku saku digital peserta.
                    </p>
                </div>
            </div>

            <form action="{{ route('trainer.trainings.update-attendance', $training->id) }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200/50 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-on-surface-variant">
                                <th class="py-3 px-4">Nama Peserta</th>
                                <th class="py-3 px-4 w-44">Status Kehadiran</th>
                                <th class="py-3 px-4 w-28">Nilai (0-100)</th>
                                <th class="py-3 px-4">Catatan Evaluasi Instruktur</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs sm:text-sm">
                            @forelse($training->attendances as $att)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-surface-container-high/40 transition-colors">
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $att->member->avatar_url }}" alt="{{ $att->member->name }}" class="w-8 h-8 rounded-full object-cover">
                                            <div>
                                                <span class="font-bold text-slate-800 dark:text-on-surface block">{{ $att->member->name }}</span>
                                                <span class="text-[11px] text-slate-400">{{ $att->member->profile?->jurusan ?? 'Peserta' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <select name="attendances[{{ $att->id }}][status_kehadiran]" class="w-full glass-input text-xs py-1.5">
                                            <option value="belum_mulai" {{ $att->status_kehadiran === 'belum_mulai' ? 'selected' : '' }}>Belum Mulai</option>
                                            <option value="hadir" {{ $att->status_kehadiran === 'hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="izin" {{ $att->status_kehadiran === 'izin' ? 'selected' : '' }}>Izin</option>
                                            <option value="sakit" {{ $att->status_kehadiran === 'sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="alpa" {{ $att->status_kehadiran === 'alpa' ? 'selected' : '' }}>Alpa</option>
                                        </select>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <input type="number"
                                               min="0"
                                               max="100"
                                               name="attendances[{{ $att->id }}][nilai]"
                                               value="{{ $att->nilai }}"
                                               placeholder="0-100"
                                               class="w-full glass-input text-xs py-1.5 text-center font-bold">
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <input type="text"
                                               name="attendances[{{ $att->id }}][catatan]"
                                               value="{{ $att->catatan }}"
                                               placeholder="Catatan keaktifan atau pemahaman materi..."
                                               class="w-full glass-input text-xs py-1.5">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-slate-400 text-xs">
                                        Belum ada peserta yang terdaftar pada modul ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($training->attendances->count() > 0)
                    <div class="flex justify-end pt-6 border-t border-slate-200/50 dark:border-white/10 mt-6">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold text-xs sm:text-sm shadow-lg shadow-red-600/30 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            <span>Simpan Rekap Absensi & Nilai</span>
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-layouts.app>

