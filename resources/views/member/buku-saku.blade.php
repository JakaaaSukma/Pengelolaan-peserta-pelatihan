<x-layouts.app title="Buku Saku Digital">
    <div class="flex flex-col gap-8">
        <!-- Header Banner Buku Saku -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-secondary-container/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-secondary-container/20 text-secondary-fixed mb-2">
                        <span class="material-symbols-outlined text-[16px] mr-1">verified</span>
                        Buku Catatan Kompetensi Peserta
                    </span>
                    <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                        Buku Saku Digital: Riwayat & Pencapaian
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1 max-w-xl">
                        Dokumentasi rekam jejak pelatihan, akumulasi nilai evaluasi teknis, serta arsip wawancara kerja yang telah Anda lalui.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="window.print()" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high hover:bg-slate-200 dark:hover:bg-surface-container-highest text-slate-700 dark:text-on-surface font-semibold text-xs md:text-sm flex items-center gap-2 shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">print</span>
                        <span>Cetak Rapor Digital</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 4 KPI Counters -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
            <x-stat-card title="Pelatihan Diikuti" :value="$totalTrainingsAttended" subtitle="Sesi Lulus" icon="school" color="primary" />
            <x-stat-card title="Total Interview" :value="$totalInterviews" subtitle="Perusahaan" icon="contact_mail" color="secondary" />
            <x-stat-card title="Wawancara Lolos" :value="$passedInterviews" subtitle="Tawaran Kerja" icon="celebration" color="emerald" badge="Prestasi" badgeType="success" />
            <x-stat-card title="Rata-rata Nilai" :value="round($averageScore ?: 0)" subtitle="Skala 100" icon="grade" color="tertiary" badge="Evaluasi" />
        </div>

        <!-- Achievement Badges Card Grid -->
        <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-lg">
            <h2 class="font-headline text-lg font-bold text-slate-800 dark:text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-500">military_tech</span>
                <span>Lencana Pencapaian & Kompetensi</span>
            </h2>
            <p class="text-xs text-slate-500 dark:text-on-surface-variant mb-6">
                Penghargaan atas komitmen belajar dan akselerasi karir Anda
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($badges as $b)
                    <div class="p-5 rounded-2xl border backdrop-blur-xl transition-all duration-300 {{
                        $b['unlocked']
                            ? 'bg-gradient-to-br ' . $b['color'] . ' shadow-md hover:scale-[1.02]'
                            : 'bg-slate-100/50 dark:bg-surface-container/30 border-slate-200/40 dark:border-white/5 opacity-50 grayscale'
                    }}">
                        <div class="flex items-center justify-between mb-3">
                            <span class="material-symbols-outlined text-3xl">{{ $b['icon'] }}</span>
                            @if($b['unlocked'])
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-white/40 dark:bg-black/20">Unlocked</span>
                            @else
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-slate-200 dark:bg-surface-variant text-slate-400">Locked</span>
                            @endif
                        </div>
                        <h3 class="font-headline font-bold text-sm text-slate-800 dark:text-on-surface">{{ $b['title'] }}</h3>
                        <p class="text-xs text-slate-600 dark:text-on-surface-variant mt-1 leading-relaxed">{{ $b['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section 1: Riwayat Pelatihan & Nilai -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-headline text-lg font-bold text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">assignment</span>
                        <span>Riwayat Pelatihan Vokasi & Evaluasi Nilai</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant mt-0.5">Daftar kehadiran dan catatan materi modul pelatihan kerja</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200/50 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-on-surface-variant">
                            <th class="py-3 px-4">Tanggal & Waktu</th>
                            <th class="py-3 px-4">Materi Pelatihan</th>
                            <th class="py-3 px-4">Instruktur</th>
                            <th class="py-3 px-4">Kehadiran</th>
                            <th class="py-3 px-4">Nilai</th>
                            <th class="py-3 px-4">Catatan Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs sm:text-sm">
                        @forelse($attendances as $att)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-surface-container-high/40 transition-colors">
                                <td class="py-4 px-4 font-medium text-slate-700 dark:text-on-surface whitespace-nowrap">
                                    {{ $att->training->tanggal->format('d M Y') }}<br>
                                    <span class="text-[11px] text-slate-400">{{ substr($att->training->jam_mulai, 0, 5) }} - {{ substr($att->training->jam_selesai, 0, 5) }} WIB</span>
                                </td>
                                <td class="py-4 px-4 max-w-xs">
                                    <span class="font-bold text-slate-800 dark:text-on-surface block">{{ $att->training->judul }}</span>
                                    <span class="text-xs text-slate-500 dark:text-on-surface-variant line-clamp-1">{{ $att->training->materi }}</span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-slate-600 dark:text-on-surface-variant">
                                    {{ $att->training->trainer->name }}
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-badge-status :status="$att->status_kehadiran" />
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if($att->nilai !== null)
                                        <span class="font-headline font-bold text-base {{ $att->nilai >= 85 ? 'text-emerald-500' : 'text-primary-container' }}">
                                            {{ $att->nilai }}/100
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-xs text-slate-600 dark:text-on-surface-variant max-w-xs">
                                    {{ $att->catatan ?? 'Belum ada catatan khusus.' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400 text-xs">
                                    Belum ada catatan kehadiran pelatihan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 2: Riwayat Interview & Feedback -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-headline text-lg font-bold text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-500">work</span>
                        <span>Riwayat Wawancara Kerja & Feedback Mitra</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant mt-0.5">Catatan hasil seleksi dan masukan dari tim rekrutmen mitra industri</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200/50 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-on-surface-variant">
                            <th class="py-3 px-4">Perusahaan & Posisi</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Metode</th>
                            <th class="py-3 px-4">Konfirmasi Anda</th>
                            <th class="py-3 px-4">Hasil Seleksi</th>
                            <th class="py-3 px-4">Feedback / Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs sm:text-sm">
                        @forelse($interviews as $inv)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-surface-container-high/40 transition-colors">
                                <td class="py-4 px-4 max-w-xs">
                                    <span class="font-bold text-slate-800 dark:text-on-surface block">{{ $inv->perusahaan }}</span>
                                    <span class="text-xs text-primary-container dark:text-primary font-semibold">{{ $inv->posisi }}</span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-slate-600 dark:text-on-surface-variant">
                                    {{ $inv->tanggal->format('d M Y') }}<br>
                                    <span class="text-[11px] text-slate-400">{{ substr($inv->jam, 0, 5) }} WIB</span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-badge-status :status="$inv->tipe" />
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-badge-status :status="$inv->confirmation?->status ?? 'menunggu'" />
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-badge-status :status="$inv->hasil" />
                                </td>
                                <td class="py-4 px-4 text-xs text-slate-600 dark:text-on-surface-variant max-w-xs">
                                    {{ $inv->feedback ?? 'Feedback dalam proses review mitra.' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400 text-xs">
                                    Belum ada data wawancara kerja yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 3: Catatan Perkembangan dari Trainer -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-lg">
            <h2 class="font-headline text-lg font-bold text-slate-800 dark:text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-rose-500">rate_review</span>
                <span>Catatan Perkembangan Instruktur</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($progressNotes as $pn)
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-surface-container-high/60 border border-slate-200/50 dark:border-white/5 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center font-bold text-xs">
                                    {{ substr($pn->trainer->name, 0, 1) }}
                                </span>
                                <div>
                                    <span class="font-bold text-xs text-slate-800 dark:text-on-surface block">{{ $pn->trainer->name }}</span>
                                    <span class="text-[10px] text-slate-400">Instruktur Vokasi</span>
                                </div>
                            </div>
                            <span class="text-[11px] text-slate-400">{{ $pn->created_at->format('d M Y') }}</span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-on-surface-variant leading-relaxed">
                            "{{ $pn->catatan }}"
                        </p>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8 text-slate-400 text-xs">
                        Belum ada catatan evaluasi khusus dari instruktur.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>

