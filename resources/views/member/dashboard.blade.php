<x-layouts.app title="Dashboard Member">
    <div class="flex flex-col gap-8">
        <!-- Hero Welcome Card -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-center gap-4 md:gap-6">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 md:w-20 md:h-20 rounded-2xl object-cover ring-4 ring-red-500/30 shadow-md">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-red-500/15 text-red-600 dark:text-rose-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600 mr-1.5 animate-ping"></span>
                                Peserta Aktif • Batch 14
                            </span>
                            <span class="text-xs text-slate-400 dark:text-on-surface-variant">• {{ $profile?->jurusan ?? 'Pencari Kerja' }}</span>
                        </div>
                        <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface tracking-tight">
                            Halo, {{ $user->name }}! 👋
                        </h1>
                        <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1 max-w-xl">
                            Pantau kemajuan kompetensi, jadwal pelatihan terpadu, dan jadwal wawancara mitra korporat secara langsung.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('member.buku-saku') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high/80 hover:bg-red-500/10 text-slate-800 dark:text-on-surface hover:text-red-600 text-xs md:text-sm font-semibold flex items-center gap-2 shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px] text-red-500">menu_book</span>
                        <span>Buka Buku Saku</span>
                    </a>
                    <a href="{{ route('member.jadwal-interview') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-500 hover:to-rose-600 text-white text-xs md:text-sm font-semibold flex items-center gap-2 shadow-md shadow-red-600/30 transition-all">
                        <span class="material-symbols-outlined text-[18px]">event_available</span>
                        <span>Jadwal Interview</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 1. Progress Tracker Horizontal -->
        <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-md">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <div>
                    <h2 class="font-headline text-lg md:text-xl font-bold text-slate-800 dark:text-on-surface">
                        Alur Perjalanan Karir Member
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant">
                        6 Tahapan terstruktur dari pendaftaran hingga siap ditempatkan kerja
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 dark:text-on-surface-variant">Kemajuan:</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500/15 text-red-600 dark:text-rose-400">
                        {{ $progressPercentage }}% Selesai
                    </span>
                </div>
            </div>

            <x-progress-timeline :stages="$timelineStages" :currentStage="$profile?->tahap_saat_ini" />
        </div>

        <!-- 2. KPI / Stat Cards (Red Dominant Accents) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <x-stat-card title="Pelatihan Dihadiri" :value="$totalTrainingsAttended" subtitle="Sesi Selesai" icon="school" color="primary" badge="Kehadiran" />
            <x-stat-card title="Jadwal Interview" :value="$totalInterviews" subtitle="Perusahaan" icon="contact_mail" color="secondary" badge="Peluang Kerja" badgeType="info" />
            <x-stat-card title="Tahap Perjalanan" :value="$profile ? $profile->progress_percentage : 16" subtitle="% Lengkap" icon="trending_up" color="tertiary" badge="Aktif" badgeType="success" />
            <x-stat-card title="Pemberitahuan" :value="$notifications->count()" subtitle="Pesan" icon="notifications" color="emerald" badge="Update Baru" />
        </div>

        <!-- 3. Upcoming Training & Upcoming Interview Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Next Training Card -->
            <div class="rounded-3xl p-6 glass-panel flex flex-col justify-between shadow-md relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="p-2.5 rounded-xl bg-red-500/15 text-red-600 dark:text-rose-400">
                            <span class="material-symbols-outlined text-[22px]">calendar_clock</span>
                        </div>
                        <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface">Pelatihan Terdekat</h3>
                    </div>
                    @if($nextTraining)
                        <x-badge-status :status="$nextTraining->tipe" />
                    @endif
                </div>

                @if($nextTraining)
                    <div class="space-y-3 my-2">
                        <h4 class="font-headline font-bold text-lg text-slate-800 dark:text-on-surface hover:text-red-600 transition-colors">
                            {{ $nextTraining->judul }}
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-on-surface-variant line-clamp-2">
                            {{ $nextTraining->materi }}
                        </p>
                        <div class="grid grid-cols-2 gap-3 pt-2 text-xs">
                            <div class="flex items-center gap-2 text-slate-600 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-red-500">event</span>
                                <span>{{ $nextTraining->tanggal->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-red-500">schedule</span>
                                <span>{{ substr($nextTraining->jam_mulai, 0, 5) }} - {{ substr($nextTraining->jam_selesai, 0, 5) }} WIB</span>
                            </div>
                            <div class="col-span-2 flex items-center gap-2 text-slate-600 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-red-500">
                                    {{ $nextTraining->isOffline() ? 'location_on' : 'videocam' }}
                                </span>
                                <span>
                                    {{ $nextTraining->isOffline() ? ($nextTraining->lokasi ?? 'Ruang Lab Vokasi') : ($nextTraining->platform . ' (' . ($nextTraining->link_meeting ?? 'Tautan di jadwal') . ')') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-200/50 dark:border-white/10 flex items-center justify-between">
                        <div class="text-xs text-slate-500">
                            Instruktur: <span class="font-semibold text-slate-700 dark:text-on-surface">{{ $nextTraining->trainer->name }}</span>
                        </div>
                        @if($nextTraining->isOnline() && $nextTraining->link_meeting)
                            <a href="{{ $nextTraining->link_meeting }}" target="_blank" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold flex items-center gap-1.5 shadow-md transition-all">
                                <span class="material-symbols-outlined text-[16px]">video_camera_front</span>
                                <span>Gabung Meeting</span>
                            </a>
                        @else
                            <a href="{{ route('member.jadwal-pelatihan') }}" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold flex items-center gap-1.5 shadow-md transition-all">
                                <span>Lihat Detail</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        @endif
                    </div>
                @else
                    <div class="text-center py-10 text-slate-400">
                        <span class="material-symbols-outlined text-4xl mb-2 opacity-50">event_busy</span>
                        <p class="text-xs">Belum ada jadwal pelatihan terdekat.</p>
                    </div>
                @endif
            </div>

            <!-- Next Interview Card with Confirmation Status -->
            <div class="rounded-3xl p-6 glass-panel flex flex-col justify-between shadow-md relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="p-2.5 rounded-xl bg-rose-500/15 text-rose-500 dark:text-rose-400">
                            <span class="material-symbols-outlined text-[22px]">contact_mail</span>
                        </div>
                        <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface">Interview Terdekat</h3>
                    </div>
                    @if($nextInterview && $nextInterview->confirmation)
                        <x-badge-status :status="$nextInterview->confirmation->status" />
                    @endif
                </div>

                @if($nextInterview)
                    <div class="space-y-3 my-2">
                        <div class="flex items-center justify-between">
                            <h4 class="font-headline font-bold text-lg text-slate-800 dark:text-on-surface">
                                {{ $nextInterview->perusahaan }}
                            </h4>
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-surface-variant text-slate-600 dark:text-on-surface-variant">
                                {{ strtoupper($nextInterview->tipe) }}
                            </span>
                        </div>
                        <p class="text-sm font-semibold text-red-600 dark:text-rose-400">
                            {{ $nextInterview->posisi }}
                        </p>
                        <div class="grid grid-cols-2 gap-3 pt-2 text-xs">
                            <div class="flex items-center gap-2 text-slate-600 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-red-500">event</span>
                                <span>{{ $nextInterview->tanggal->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-red-500">schedule</span>
                                <span>{{ substr($nextInterview->jam, 0, 5) }} WIB</span>
                            </div>
                        </div>

                        <!-- Confirmation Alert if Waiting -->
                        @if($nextInterview->confirmation && $nextInterview->confirmation->status === 'menunggu')
                            <div class="p-3 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px] text-amber-500">priority_high</span>
                                    <span>Konfirmasi kehadiran Anda diperlukan segera!</span>
                                </div>
                                <a href="{{ route('member.jadwal-interview') }}" class="font-bold underline text-amber-600 dark:text-amber-200">Konfirmasi</a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-200/50 dark:border-white/10 flex items-center justify-between">
                        <span class="text-xs text-slate-500">
                            Countdown: <span class="font-semibold text-slate-700 dark:text-on-surface">{{ $nextInterview->tanggal->diffForHumans() }}</span>
                        </span>
                        <a href="{{ route('member.jadwal-interview') }}" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold flex items-center gap-1.5 shadow-md transition-all">
                            <span>Buka Jadwal & Konfirmasi</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                @else
                    <div class="text-center py-10 text-slate-400">
                        <span class="material-symbols-outlined text-4xl mb-2 opacity-50">work_outline</span>
                        <p class="text-xs">Belum ada jadwal wawancara kerja yang dijadwalkan.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- 4. Progress Notes from Trainer & Recent Notifications -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Progress Notes from Trainer -->
            <div class="lg:col-span-2 rounded-3xl p-6 glass-panel shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-600 dark:text-rose-400">rate_review</span>
                        <span>Catatan Perkembangan dari Trainer</span>
                    </h3>
                    <a href="{{ route('member.buku-saku') }}" class="text-xs text-red-600 dark:text-rose-400 font-semibold hover:underline">Lihat Buku Saku →</a>
                </div>

                @php
                    $latestNotes = $user->progressNotesAsMember()->with('trainer')->latest()->take(3)->get();
                @endphp

                <div class="space-y-3">
                    @forelse($latestNotes as $note)
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-surface-container-high/50 border border-slate-200/40 dark:border-white/5 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <span class="font-semibold text-xs text-slate-800 dark:text-on-surface">{{ $note->trainer->name }}</span>
                                </div>
                                <span class="text-[11px] text-slate-400">{{ $note->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-on-surface-variant leading-relaxed">
                                "{{ $note->catatan }}"
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            Belum ada catatan evaluasi dari trainer.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Notifications Mini Feed -->
            <div class="rounded-3xl p-6 glass-panel shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-500">notifications</span>
                        <span>Pemberitahuan</span>
                    </h3>
                    <span class="text-xs text-slate-400">{{ $notifications->count() }} Terkini</span>
                </div>

                <div class="space-y-3">
                    @forelse($notifications as $notif)
                        <div class="p-3 rounded-2xl bg-slate-50/80 dark:bg-surface-container-high/40 text-xs space-y-1">
                            <span class="font-semibold text-slate-800 dark:text-on-surface block">{{ $notif->judul }}</span>
                            <p class="text-slate-500 dark:text-on-surface-variant line-clamp-2">{{ $notif->pesan }}</p>
                            <span class="text-[10px] text-slate-400 block pt-1">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            Tidak ada notifikasi baru.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
