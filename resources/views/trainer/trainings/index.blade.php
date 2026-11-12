<x-layouts.app title="Kelola Pelatihan">
    <div class="flex flex-col gap-6" x-data="{ showCreateModal: false }">
        <!-- Header -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-container/20 text-primary-container dark:text-tertiary mb-2">
                    <span class="material-symbols-outlined text-[16px] mr-1">calendar_month</span>
                    Kurikulum Vokasi
                </span>
                <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                    Kelola Jadwal Pelatihan
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1">
                    Buat jadwal kelas workshop tatap muka (offline) atau webinar (online), serta input absensi dan nilai peserta.
                </p>
            </div>

            <button type="button"
                    @click="showCreateModal = true"
                    class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold text-xs md:text-sm flex items-center gap-2 shadow-lg shadow-red-600/30 transition-all">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Buat Jadwal Baru</span>
            </button>
        </div>

        <!-- Trainings Grid / Table -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($trainings as $t)
                <div class="p-6 rounded-3xl glass-panel shadow-lg flex flex-col justify-between gap-4 group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <x-badge-status :status="$t->tipe" />
                            <span class="text-xs text-slate-400">{{ $t->attendances->count() }} Peserta Terdaftar</span>
                        </div>

                        <h3 class="font-headline font-bold text-lg text-slate-800 dark:text-on-surface mb-2">
                            {{ $t->judul }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-on-surface-variant line-clamp-2 mb-4 leading-relaxed">
                            {{ $t->materi }}
                        </p>

                        <div class="p-3.5 rounded-2xl bg-slate-50/70 dark:bg-surface-container-high/40 text-xs space-y-1.5">
                            <div class="flex items-center gap-2 text-slate-700 dark:text-on-surface font-semibold">
                                <span class="material-symbols-outlined text-[18px] text-primary-container">event</span>
                                <span>{{ $t->tanggal->format('l, d F Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-500 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-primary-container">schedule</span>
                                <span>{{ substr($t->jam_mulai, 0, 5) }} - {{ substr($t->jam_selesai, 0, 5) }} WIB</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-500 dark:text-on-surface-variant">
                                <span class="material-symbols-outlined text-[18px] text-primary-container">
                                    {{ $t->isOffline() ? 'location_on' : 'videocam' }}
                                </span>
                                <span>{{ $t->isOffline() ? ($t->lokasi ?? 'Workshop Lab') : ($t->platform ?? 'Online Meeting') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div class="pt-4 border-t border-slate-200/50 dark:border-white/10 flex items-center justify-between">
                        <form action="{{ route('trainer.trainings.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal pelatihan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl text-rose-500 hover:bg-rose-500/10 transition-colors" title="Hapus Jadwal">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>

                        <a href="{{ route('trainer.trainings.show', $t->id) }}" class="px-4 py-2 rounded-xl bg-primary-container hover:bg-red-700 text-white font-semibold text-xs flex items-center gap-1.5 shadow-md transition-all">
                            <span class="material-symbols-outlined text-[16px]">fact_check</span>
                            <span>Absensi & Nilai</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-16 text-slate-400 glass-panel rounded-3xl">
                    <span class="material-symbols-outlined text-5xl mb-2 opacity-50">calendar_month</span>
                    <p class="text-sm font-semibold">Belum ada modul pelatihan yang dibuat.</p>
                </div>
            @endforelse
        </div>

        @if($trainings->hasPages())
            <div class="p-4">
                {{ $trainings->links() }}
            </div>
        @endif

        <!-- Create Training Modal -->
        <div x-show="showCreateModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div @click.outside="showCreateModal = false" class="w-full max-w-lg glass-modal rounded-3xl p-6 shadow-2xl relative max-h-[90vh] overflow-y-auto"
                 x-data="{ tipe: 'offline' }">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200/50 dark:border-white/10 mb-4">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface">Buat Jadwal Pelatihan Baru</h3>
                    <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form action="{{ route('trainer.trainings.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="judul" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Judul Pelatihan *</label>
                        <input type="text" name="judul" id="judul" required placeholder="Contoh: Laravel Architecture & API" class="w-full glass-input text-xs sm:text-sm">
                    </div>

                    <div>
                        <label for="materi" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Ringkasan Materi *</label>
                        <textarea name="materi" id="materi" rows="3" required placeholder="Rincian materi modul yang diajarkan..." class="w-full glass-input text-xs sm:text-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="tipe" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Metode Pelatihan *</label>
                            <select name="tipe" id="tipe" x-model="tipe" required class="w-full glass-input text-xs sm:text-sm">
                                <option value="offline">Offline (Tatap Muka)</option>
                                <option value="online">Online (Virtual Webinar)</option>
                            </select>
                        </div>
                        <div>
                            <label for="tanggal" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tanggal Pelaksanaan *</label>
                            <input type="date" name="tanggal" id="tanggal" required class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="jam_mulai" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Jam Mulai *</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" required value="09:00" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="jam_selesai" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Jam Selesai *</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" required value="16:00" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div x-show="tipe === 'offline'">
                        <label for="lokasi" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Lokasi / Ruangan Lab</label>
                        <input type="text" name="lokasi" id="lokasi" placeholder="Contoh: Ruang Workshop Lab Komputer 2" class="w-full glass-input text-xs sm:text-sm">
                    </div>

                    <div x-show="tipe === 'online'" style="display: none;" class="space-y-3">
                        <div>
                            <label for="platform" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Platform Webinar</label>
                            <input type="text" name="platform" id="platform" placeholder="Contoh: Zoom Workplace / Google Meet" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="link_meeting" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tautan Link Meeting</label>
                            <input type="url" name="link_meeting" id="link_meeting" placeholder="https://meet.google.com/xyz" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-200/50 dark:border-white/10">
                        <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-surface-container-high text-xs font-semibold text-slate-700 dark:text-on-surface">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-container text-white text-xs font-semibold shadow-md hover:bg-red-700 transition-all">
                            Simpan & Bagikan ke Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>

