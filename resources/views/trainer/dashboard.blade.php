<x-layouts.app title="Dashboard Trainer">
    <div class="flex flex-col gap-8">
        <!-- Trainer Welcome Banner -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-center gap-4 md:gap-6">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gradient-to-tr from-red-600 to-rose-700 flex items-center justify-center text-white shadow-lg shadow-red-600/30">
                        <span class="material-symbols-outlined text-4xl">supervisor_account</span>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-red-500/15 text-red-600 dark:text-rose-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600 mr-1.5 animate-ping"></span>
                                Instruktur & Supervisor Vokasi
                            </span>
                            <span class="text-xs text-slate-400 dark:text-on-surface-variant">• Q4 Pipeline Monitoring</span>
                        </div>
                        <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface tracking-tight">
                            Kelola Member & Monitoring Penempatan Kerja
                        </h1>
                        <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1 max-w-2xl">
                            Pantau performa harian peserta pelatihan vokasi, kelayakan kompetensi teknis, serta akselerasi pipeline wawancara mitra industri.
                        </p>
                    </div>
                </div>

                <!-- Global Quick Actions -->
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('trainer.trainings.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high/80 hover:bg-red-500/10 text-slate-700 dark:text-on-surface hover:text-red-600 font-semibold text-xs md:text-sm flex items-center gap-2 shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px] text-red-500">calendar_month</span>
                        <span>Jadwal Pelatihan</span>
                    </a>
                    <a href="{{ route('trainer.interviews.index') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-500 hover:to-rose-600 text-white font-semibold text-xs md:text-sm flex items-center gap-2 shadow-md shadow-red-600/30 transition-all">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        <span>Jadwal Interview Baru</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- KPI Stat Cards (4 Grid) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <x-stat-card title="Total Member Terdaftar" :value="$totalMembers" subtitle="Peserta" icon="group" color="primary" badge="Terdaftar" />
            <x-stat-card title="Member Aktif Profil" :value="$activeMembers" subtitle="Lengkap" icon="verified_user" color="tertiary" badge="Siap Kerja" badgeType="success" />
            <x-stat-card title="Interview Minggu Ini" :value="$interviewsThisWeek" subtitle="Sesi Aktif" icon="contact_mail" color="secondary" badge="Rekrutmen" badgeType="warning" />
            <x-stat-card title="Telah Ditempatkan" :value="$placedMembersCount" subtitle="Kandidat Kerja" icon="work" color="emerald" badge="Disalurkan" badgeType="success" />
        </div>

        <!-- 2. Visual Distribution of Member Stages (Bar Progress Chart) -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-md space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-headline text-lg font-bold text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-600 dark:text-rose-400">bar_chart</span>
                        <span>Distribusi Tahapan Peserta (Pipeline Funnel)</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant">Sebaran peserta pelatihan di setiap tahap perjalanan karir</p>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500"></span> Belum Ditempatkan ({{ $unplacedMembersCount }})</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Sudah Ditempatkan ({{ $placedMembersCount }})</span>
                </div>
            </div>

            <!-- Stages Grid Visual Bar with Red-Hued Color Palette -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                @php
                    $stageMetadata = [
                        'pendaftaran' => ['label' => '1. Pendaftaran', 'color' => 'bg-slate-400'],
                        'melengkapi_data' => ['label' => '2. Lengkapi Data', 'color' => 'bg-rose-400'],
                        'pelatihan' => ['label' => '3. Pelatihan', 'color' => 'bg-red-500'],
                        'evaluasi' => ['label' => '4. Evaluasi', 'color' => 'bg-red-700'],
                        'interview' => ['label' => '5. Interview', 'color' => 'bg-rose-600'],
                        'penempatan_kerja' => ['label' => '6. Ditempatkan', 'color' => 'bg-emerald-500'],
                    ];
                @endphp

                @foreach($stagesDistribution as $key => $count)
                    @php
                        $meta = $stageMetadata[$key] ?? ['label' => ucfirst($key), 'color' => 'bg-red-600'];
                        $pct = $totalMembers > 0 ? round(($count / $totalMembers) * 100) : 0;
                    @endphp
                    <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-surface-container-high/40 border border-slate-200/40 dark:border-white/5 space-y-2">
                        <span class="text-[11px] font-semibold text-slate-500 dark:text-on-surface-variant block truncate">{{ $meta['label'] }}</span>
                        <div class="flex items-baseline justify-between">
                            <span class="font-headline text-2xl font-bold text-slate-800 dark:text-on-surface">{{ $count }}</span>
                            <span class="text-[11px] text-slate-400">{{ $pct }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-surface-variant h-1.5 rounded-full overflow-hidden">
                            <div class="{{ $meta['color'] }} h-full rounded-full transition-all duration-300" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 3. Recent Registered Members Table -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-md">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-headline text-lg font-bold text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-600 dark:text-rose-400">recent_actors</span>
                        <span>Peserta Terbaru Masuk Monitoring</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant mt-0.5">Daftar kandidat yang baru bergabung ke pelatihan vokasi</p>
                </div>
                <a href="{{ route('trainer.members.index') }}" class="text-xs font-semibold text-red-600 dark:text-rose-400 hover:underline flex items-center gap-1">
                    <span>Lihat Semua Member</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200/50 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-on-surface-variant bg-slate-50/50 dark:bg-surface-container-highest/20">
                            <th class="py-3 px-4">Nama Peserta</th>
                            <th class="py-3 px-4">Pendidikan & Jurusan</th>
                            <th class="py-3 px-4">Tahap Saat Ini</th>
                            <th class="py-3 px-4">Status Penempatan</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs sm:text-sm">
                        @foreach($recentMembers as $m)
                            <tr class="hover:bg-red-500/5 transition-colors">
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $m->avatar_url }}" alt="{{ $m->name }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-red-500/20">
                                        <div>
                                            <span class="font-bold text-slate-800 dark:text-on-surface block">{{ $m->name }}</span>
                                            <span class="text-[11px] text-slate-400">{{ $m->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-slate-600 dark:text-on-surface-variant">
                                    {{ $m->profile?->jurusan ?? '-' }}<br>
                                    <span class="text-[11px] text-slate-400">{{ $m->profile?->pendidikan_terakhir ?? 'Belum isi' }}</span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/15 text-red-600 dark:text-rose-400">
                                        {{ ucfirst(str_replace('_', ' ', $m->profile?->tahap_saat_ini ?? 'pendaftaran')) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <x-badge-status :status="$m->latestPlacement?->status ?? 'proses'" />
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-right">
                                    <a href="{{ route('trainer.members.show', $m->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-surface-container-high hover:bg-red-600 hover:text-white dark:hover:bg-red-600 text-xs font-semibold transition-all">
                                        Detail & Evaluasi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Upcoming Schedules Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upcoming Trainings -->
            <div class="rounded-3xl p-6 glass-panel shadow-md space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-600 dark:text-rose-400">calendar_month</span>
                        <span>Pelatihan Mendatang</span>
                    </h3>
                    <a href="{{ route('trainer.trainings.index') }}" class="text-xs text-red-600 dark:text-rose-400 font-semibold hover:underline">Kelola →</a>
                </div>

                <div class="space-y-3">
                    @forelse($upcomingTrainings as $ut)
                        <div class="p-4 rounded-2xl bg-slate-50/70 dark:bg-surface-container-high/40 flex items-center justify-between gap-4">
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-on-surface block">{{ $ut->judul }}</span>
                                <span class="text-[11px] text-slate-400">{{ $ut->tanggal->format('d M Y') }} • {{ substr($ut->jam_mulai, 0, 5) }} WIB • {{ strtoupper($ut->tipe) }}</span>
                            </div>
                            <x-badge-status :status="$ut->tipe" />
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">Belum ada jadwal pelatihan mendatang.</div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Interviews & Confirmation Tracking -->
            <div class="rounded-3xl p-6 glass-panel shadow-md space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-rose-500">fact_check</span>
                        <span>Interview & Konfirmasi Member</span>
                    </h3>
                    <a href="{{ route('trainer.interviews.index') }}" class="text-xs text-red-600 dark:text-rose-400 font-semibold hover:underline">Kelola →</a>
                </div>

                <div class="space-y-3">
                    @forelse($upcomingInterviews as $ui)
                        <div class="p-4 rounded-2xl bg-slate-50/70 dark:bg-surface-container-high/40 flex items-center justify-between gap-4">
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-on-surface block">{{ $ui->member->name }}</span>
                                <span class="text-[11px] text-slate-400">{{ $ui->perusahaan }} ({{ $ui->posisi }}) • {{ $ui->tanggal->format('d M') }}</span>
                            </div>
                            <x-badge-status :status="$ui->confirmation?->status ?? 'menunggu'" />
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">Belum ada agenda interview mendatang.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
