<x-layouts.app title="Jadwal Pelatihan">
    <div class="flex flex-col gap-8" x-data="{
        showMapModal: false,
        modalLocation: '',
        modalTitle: '',
        openMap(title, loc) {
            this.modalTitle = title;
            this.modalLocation = loc;
            this.showMapModal = true;
        }
    }">
        <!-- Header -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/15 text-red-600 dark:text-rose-400 mb-2">
                    <span class="material-symbols-outlined text-[16px] mr-1">school</span>
                    Modul Pelatihan Vokasi
                </span>
                <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                    Jadwal Pelatihan & Workshop
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1">
                    Ikuti setiap sesi pelatihan offline maupun webinar online untuk memenuhi syarat kompetensi penempatan kerja.
                </p>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center p-1 rounded-2xl bg-slate-100/90 dark:bg-surface-container/70 border border-slate-200/50 dark:border-white/5 shadow-inner">
                <a href="{{ route('member.jadwal-pelatihan', ['tipe' => 'all']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $filter === 'all' ? 'bg-white dark:bg-primary-container text-primary-container dark:text-white shadow-sm' : 'text-slate-600 dark:text-on-surface-variant hover:text-slate-900 dark:hover:text-on-surface' }}">
                    Semua
                </a>
                <a href="{{ route('member.jadwal-pelatihan', ['tipe' => 'offline']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $filter === 'offline' ? 'bg-white dark:bg-primary-container text-primary-container dark:text-white shadow-sm' : 'text-slate-600 dark:text-on-surface-variant hover:text-slate-900 dark:hover:text-on-surface' }}">
                    Offline ({{ $offlineCount }})
                </a>
                <a href="{{ route('member.jadwal-pelatihan', ['tipe' => 'online']) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $filter === 'online' ? 'bg-white dark:bg-primary-container text-primary-container dark:text-white shadow-sm' : 'text-slate-600 dark:text-on-surface-variant hover:text-slate-900 dark:hover:text-on-surface' }}">
                    Online ({{ $onlineCount }})
                </a>
            </div>
        </div>

        <!-- Training Schedule Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($trainings as $t)
                @php
                    $myAttendance = $t->attendances->first();
                    $isPast = $t->tanggal->isPast();
                @endphp
                <div class="rounded-3xl p-6 glass-panel glass-card-hover flex flex-col justify-between shadow-lg relative overflow-hidden group">
                    <div>
                        <!-- Header Card with Mode & Attendance -->
                        <div class="flex items-center justify-between mb-3">
                            <x-badge-status :status="$t->tipe" />
                            @if($myAttendance)
                                <x-badge-status :status="$myAttendance->status_kehadiran" />
                            @else
                                <span class="text-xs text-slate-400">Belum Terdaftar</span>
                            @endif
                        </div>

                        <!-- Title & Description -->
                        <h3 class="font-headline font-bold text-lg text-slate-800 dark:text-on-surface group-hover:text-primary-container transition-colors mb-2">
                            {{ $t->judul }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-on-surface-variant leading-relaxed line-clamp-3 mb-4">
                            {{ $t->materi }}
                        </p>

                        <!-- Details Grid -->
                        <div class="space-y-2 p-3.5 rounded-2xl bg-slate-50/70 dark:bg-surface-container-high/40 text-xs">
                            <div class="flex items-center gap-2.5 text-slate-700 dark:text-on-surface">
                                <span class="material-symbols-outlined text-[18px] text-primary-container">calendar_month</span>
                                <span class="font-semibold">{{ $t->tanggal->format('l, d F Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-slate-600 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-primary-container">schedule</span>
                                <span>{{ substr($t->jam_mulai, 0, 5) }} - {{ substr($t->jam_selesai, 0, 5) }} WIB</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-slate-600 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-primary-container">person</span>
                                <span>Instruktur: <strong class="text-slate-800 dark:text-on-surface">{{ $t->trainer->name }}</strong></span>
                            </div>

                            @if($t->isOffline())
                                <div class="flex items-start gap-2.5 text-slate-600 dark:text-on-surface-variant pt-1 border-t border-slate-200/50 dark:border-white/5">
                                    <span class="material-symbols-outlined text-[18px] text-red-500 shrink-0">location_on</span>
                                    <span>{{ $t->lokasi ?? 'Pusat Pelatihan Vokasi Terpadu' }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2.5 text-slate-600 dark:text-on-surface-variant pt-1 border-t border-slate-200/50 dark:border-white/5">
                                    <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0">videocam</span>
                                    <span>Platform: <strong class="text-slate-800 dark:text-on-surface">{{ $t->platform ?? 'Video Conference' }}</strong></span>
                                </div>
                            @endif
                            @if($t->modules->count() > 0)
                                <div class="pt-2 border-t border-slate-200/50 dark:border-white/5 space-y-1">
                                    <span class="text-[10px] uppercase font-bold text-slate-400">Berkas Modul Pelatihan:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($t->modules as $mod)
                                            <a href="{{ route('member.modules.download', $mod->id) }}"
                                               class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-600 dark:text-rose-400 text-[11px] font-semibold transition-all">
                                                <span class="material-symbols-outlined text-[14px]">{{ $mod->icon }}</span>
                                                <span class="truncate max-w-[140px]">{{ $mod->judul }}</span>
                                                <span class="text-[9px] uppercase opacity-75">({{ $mod->file_type }})</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Bottom Actions -->
                    <div class="mt-5 pt-4 border-t border-slate-200/50 dark:border-white/10 flex items-center justify-between">
                        @if($myAttendance && $myAttendance->nilai !== null)
                            <div class="text-xs">
                                Nilai: <strong class="text-emerald-500 font-headline font-bold text-sm">{{ $myAttendance->nilai }}/100</strong>
                            </div>
                        @else
                            <span class="text-[11px] text-slate-400">{{ $isPast ? 'Sesi telah berlalu' : 'Akan datang' }}</span>
                        @endif

                        @if($t->isOffline())
                            <button type="button"
                                    @click="openMap('{{ addslashes($t->judul) }}', '{{ addslashes($t->lokasi ?? 'Pusat Pelatihan Kerja Vokasi') }}')"
                                    class="px-4 py-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-600 dark:text-rose-400 text-xs font-semibold flex items-center gap-1.5 transition-all">
                                <span class="material-symbols-outlined text-[16px]">map</span>
                                <span>Lihat Peta Lokasi</span>
                            </button>
                        @elseif($t->isOnline())
                            @if($t->link_meeting)
                                <a href="{{ $t->link_meeting }}" target="_blank" class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white text-xs font-semibold flex items-center gap-1.5 shadow-md transition-all">
                                    <span class="material-symbols-outlined text-[16px]">video_camera_front</span>
                                    <span>Gabung Meeting</span>
                                </a>
                            @else
                                <span class="text-xs text-slate-400 italic">Tautan meeting segera dirilis</span>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-16 text-slate-400 glass-panel rounded-3xl">
                    <span class="material-symbols-outlined text-5xl mb-2 opacity-50">event_busy</span>
                    <p class="text-sm font-semibold">Tidak ada jadwal pelatihan untuk filter ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Offline Location Map Modal (Glassmorphic) -->
        <div x-show="showMapModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div @click.outside="showMapModal = false" class="w-full max-w-lg glass-modal rounded-3xl p-6 shadow-2xl relative">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200/50 dark:border-white/10 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-500">pin_drop</span>
                        <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface">Peta Lokasi Workshop</h3>
                    </div>
                    <button @click="showMapModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Materi Sesi:</span>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-on-surface" x-text="modalTitle"></h4>
                    </div>

                    <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-xs text-slate-700 dark:text-slate-200">
                        <span class="font-semibold block mb-1">Alamat / Ruangan:</span>
                        <p x-text="modalLocation"></p>
                    </div>

                    <!-- Simulated Visual Interactive Map Glass Container -->
                    <div class="w-full h-48 rounded-2xl bg-slate-200 dark:bg-surface-container-high relative overflow-hidden flex items-center justify-center border border-slate-300 dark:border-white/10">
                        <div class="absolute inset-0 opacity-40 bg-[radial-gradient(#dc2626_1px,transparent_1px)] [background-size:16px_16px]"></div>
                        <div class="relative z-10 flex flex-col items-center text-center p-4">
                            <span class="material-symbols-outlined text-4xl text-rose-500 animate-bounce">location_on</span>
                            <span class="font-bold text-xs text-slate-800 dark:text-on-surface mt-1" x-text="modalLocation"></span>
                            <span class="text-[10px] text-slate-400">Gedung Pusat Pelatihan Vokasi & Akselerasi Karir</span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a :href="`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(modalLocation)}`"
                           target="_blank"
                           class="px-5 py-2.5 rounded-xl bg-primary-container text-white text-xs font-semibold flex items-center gap-1.5 shadow-md hover:bg-red-700 transition-all">
                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            <span>Buka di Google Maps</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

