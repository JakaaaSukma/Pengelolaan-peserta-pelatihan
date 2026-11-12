<x-layouts.app title="Jadwal Interview">
    <div class="flex flex-col gap-8" x-data="{
        showModal: false,
        modalAction: '',
        modalStatus: '',
        modalTitle: '',
        modalInterviewId: null,
        openConfirmModal(interviewId, status, title) {
            this.modalInterviewId = interviewId;
            this.modalStatus = status;
            this.modalTitle = title;
            this.showModal = true;
        }
    }">
        <!-- Header -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/15 text-red-600 dark:text-rose-400 mb-2">
                    <span class="material-symbols-outlined text-[16px] mr-1">event_available</span>
                    Pipeline Rekrutmen Industri
                </span>
                <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                    Jadwal Wawancara Kerja & Konfirmasi
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1 max-w-2xl">
                    Pastikan Anda selalu melakukan konfirmasi kehadiran tepat waktu agar instruktur dan pihak HR korporat dapat mengalokasikan slot wawancara.
                </p>
            </div>
        </div>

        <!-- Upcoming Countdown Highlight Card -->
        @if($upcomingInterview)
            <div class="p-6 md:p-8 rounded-3xl glass-panel border border-red-500/30 shadow-2xl relative overflow-hidden"
                 x-data="{
                    target: new Date('{{ $upcomingInterview->tanggal->format('Y-m-d') }}T{{ $upcomingInterview->jam }}').getTime(),
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    init() {
                        this.update();
                        setInterval(() => this.update(), 1000);
                    },
                    update() {
                        let now = new Date().getTime();
                        let diff = this.target - now;
                        if (diff > 0) {
                            this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                            this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        }
                    }
                 }">
                <div class="absolute -right-12 -top-12 w-48 h-48 bg-red-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                            <span class="text-xs uppercase font-bold tracking-wider text-red-600 dark:text-rose-400">Countdown Sesi Terdekat</span>
                        </div>
                        <h2 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                            {{ $upcomingInterview->perusahaan }}
                        </h2>
                        <p class="text-sm font-semibold text-primary-container dark:text-primary mt-1">
                            Posisi: {{ $upcomingInterview->posisi }} ({{ strtoupper($upcomingInterview->tipe) }})
                        </p>
                        <p class="text-xs text-slate-500 dark:text-on-surface-variant mt-1">
                            Jadwal: {{ $upcomingInterview->tanggal->format('l, d F Y') }} pukul {{ substr($upcomingInterview->jam, 0, 5) }} WIB
                        </p>
                    </div>

                    <!-- Countdown Digital Clock Timer -->
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col items-center justify-center w-16 h-20 sm:w-20 sm:h-24 rounded-2xl glass-card text-slate-800 dark:text-on-surface">
                            <span class="font-headline text-2xl sm:text-3xl font-extrabold text-red-600 dark:text-rose-400" x-text="days">0</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 mt-1">Hari</span>
                        </div>
                        <span class="text-2xl font-bold text-slate-400">:</span>
                        <div class="flex flex-col items-center justify-center w-16 h-20 sm:w-20 sm:h-24 rounded-2xl glass-card text-slate-800 dark:text-on-surface">
                            <span class="font-headline text-2xl sm:text-3xl font-extrabold text-red-500 dark:text-rose-400" x-text="hours">0</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 mt-1">Jam</span>
                        </div>
                        <span class="text-2xl font-bold text-slate-400">:</span>
                        <div class="flex flex-col items-center justify-center w-16 h-20 sm:w-20 sm:h-24 rounded-2xl glass-card text-slate-800 dark:text-on-surface">
                            <span class="font-headline text-2xl sm:text-3xl font-extrabold text-rose-500 dark:text-secondary" x-text="minutes">0</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 mt-1">Menit</span>
                        </div>
                        <span class="text-2xl font-bold text-slate-400">:</span>
                        <div class="flex flex-col items-center justify-center w-16 h-20 sm:w-20 sm:h-24 rounded-2xl glass-card text-slate-800 dark:text-on-surface">
                            <span class="font-headline text-2xl sm:text-3xl font-extrabold text-rose-400" x-text="seconds">0</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 mt-1">Detik</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- List of All Interviews -->
        <div class="space-y-6">
            @forelse($interviews as $inv)
                @php
                    $conf = $inv->confirmation;
                    $status = $conf ? $conf->status : 'menunggu';
                @endphp
                <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-lg flex flex-col justify-between gap-6">
                    <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-surface-variant text-slate-600 dark:text-on-surface-variant">
                                    {{ strtoupper($inv->tipe) }}
                                </span>
                                <x-badge-status :status="$status" />
                                <x-badge-status :status="$inv->hasil" />
                            </div>

                            <h3 class="font-headline text-xl md:text-2xl font-bold text-slate-800 dark:text-on-surface">
                                {{ $inv->perusahaan }}
                            </h3>
                            <p class="text-sm font-semibold text-primary-container dark:text-primary">
                                Posisi: {{ $inv->posisi }}
                            </p>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-600 dark:text-on-surface-variant pt-2">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-red-500">calendar_month</span>
                                    <span>{{ $inv->tanggal->format('l, d F Y') }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-red-500">schedule</span>
                                    <span>{{ substr($inv->jam, 0, 5) }} WIB</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-red-500">
                                        {{ $inv->tipe === 'offline' ? 'location_on' : 'videocam' }}
                                    </span>
                                    <span>
                                        {{ $inv->tipe === 'offline' ? ($inv->lokasi ?? 'Kantor Pusat Mitra') : ($inv->link ? 'Online Meeting Room' : 'Tautan disediakan mitra') }}
                                    </span>
                                </div>
                            </div>

                            @if($conf && $conf->alasan)
                                <div class="p-3 rounded-xl bg-slate-100/80 dark:bg-surface-container-high/60 text-xs text-slate-600 dark:text-on-surface-variant mt-2">
                                    <strong>Catatan Alasan Anda:</strong> "{{ $conf->alasan }}"
                                </div>
                            @endif

                            @if($inv->feedback)
                                <div class="p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-xs text-red-700 dark:text-red-300 mt-2">
                                    <strong>Feedback Perusahaan:</strong> "{{ $inv->feedback }}"
                                </div>
                            @endif
                        </div>

                        <!-- Action Confirmation Buttons -->
                        <div class="flex flex-col sm:flex-row lg:flex-col gap-2.5 shrink-0 min-w-[220px]">
                            @if($inv->tipe === 'online' && $inv->link)
                                <a href="{{ $inv->link }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-xs flex items-center justify-center gap-2 shadow-md transition-all">
                                    <span class="material-symbols-outlined text-[18px]">video_camera_front</span>
                                    <span>Buka Meeting Room</span>
                                </a>
                            @endif

                            <!-- Hadir Button (Direct Form Post) -->
                            <form action="{{ route('member.jadwal-interview.confirm', $inv->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="hadir">
                                <button type="submit"
                                        class="w-full py-2.5 px-4 rounded-xl font-semibold text-xs flex items-center justify-center gap-1.5 transition-all {{
                                            $status === 'hadir'
                                                ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30'
                                                : 'bg-emerald-500/15 hover:bg-emerald-500 hover:text-white text-emerald-600 dark:text-emerald-400 border border-emerald-500/30'
                                        }}">
                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    <span>{{ $status === 'hadir' ? 'Telah Konfirmasi Hadir' : 'Konfirmasi [Hadir]' }}</span>
                                </button>
                            </form>

                            <div class="grid grid-cols-2 gap-2">
                                <!-- Tidak Hadir Button -->
                                <button type="button"
                                        @click="openConfirmModal({{ $inv->id }}, 'tidak_hadir', 'Konfirmasi Tidak Hadir')"
                                        class="py-2 px-3 rounded-xl font-semibold text-xs flex items-center justify-center gap-1 transition-all {{
                                            $status === 'tidak_hadir'
                                                ? 'bg-rose-500 text-white shadow-md'
                                                : 'bg-rose-500/10 hover:bg-rose-500 hover:text-white text-rose-600 dark:text-rose-400 border border-rose-500/30'
                                        }}">
                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                    <span>Tidak Hadir</span>
                                </button>

                                <!-- Minta Reschedule Button -->
                                <button type="button"
                                        @click="openConfirmModal({{ $inv->id }}, 'reschedule', 'Minta Reschedule Wawancara')"
                                        class="py-2 px-3 rounded-xl font-semibold text-xs flex items-center justify-center gap-1 transition-all {{
                                            $status === 'reschedule'
                                                ? 'bg-amber-500 text-white shadow-md'
                                                : 'bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 border border-amber-500/30'
                                        }}">
                                    <span class="material-symbols-outlined text-[16px]">schedule_send</span>
                                    <span>Reschedule</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 text-slate-400 glass-panel rounded-3xl">
                    <span class="material-symbols-outlined text-5xl mb-2 opacity-50">calendar_month</span>
                    <p class="text-sm font-semibold">Belum ada agenda wawancara kerja yang dijadwalkan.</p>
                </div>
            @endforelse
        </div>

        <!-- Modal Alasan Konfirmasi (Tidak Hadir / Reschedule) -->
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div @click.outside="showModal = false" class="w-full max-w-md glass-modal rounded-3xl p-6 shadow-2xl relative">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200/50 dark:border-white/10 mb-4">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface" x-text="modalTitle"></h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form :action="`/member/jadwal-interview/${modalInterviewId}/confirm`" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="status" :value="modalStatus">

                    <div>
                        <label for="alasan" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">
                            Alasan Wajib Diisi:
                        </label>
                        <textarea name="alasan" id="alasan" rows="4" required
                                  placeholder="Jelaskan kendala Anda secara profesional (contoh: kondisi kesehatan, jadwal bertabrakan, dll)..."
                                  class="w-full glass-input text-xs sm:text-sm"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-surface-container-high text-xs font-semibold text-slate-700 dark:text-on-surface">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-container text-white text-xs font-semibold shadow-md hover:bg-red-700 transition-all">
                            Kirim Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>

