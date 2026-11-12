<x-layouts.app title="Kelola Modul Pelatihan">
    <div class="space-y-8" 
         x-data="{
            showUploadModal: false,
            showViewerModal: false,
            activeModul: {
                id: null,
                judul: '',
                deskripsi: '',
                kategori: '',
                tipe: 'pdf',
                isPdf: true,
                size: '',
                trainer: '',
                previewUrl: '',
                downloadUrl: ''
            },
            openViewer(data) {
                this.activeModul = { ...data };
                this.showViewerModal = true;
            }
         }">
        <!-- Header -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/15 text-red-600 dark:text-rose-400 mb-2">
                    <span class="material-symbols-outlined text-[16px] mr-1">library_books</span>
                    Pusat Materi & Sumber Belajar
                </span>
                <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                    Kelola Modul Pelatihan (PPT / PDF)
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1">
                    Unggah materi presentasi (PPT/PPTX) dan panduan teknis (PDF) yang dapat dilihat langsung secara interaktif oleh peserta.
                </p>
            </div>

            <button type="button"
                    @click="showUploadModal = true"
                    class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold text-xs md:text-sm flex items-center gap-2 shadow-lg shadow-red-600/30 transition-all shrink-0">
                <span class="material-symbols-outlined text-[18px]">upload_file</span>
                <span>Unggah Modul Baru</span>
            </button>
        </div>

        <!-- Filter & Search Bar -->
        <div class="p-4 md:p-5 rounded-2xl glass-panel shadow-sm">
            <form action="{{ route('trainer.modules.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">
                <div class="relative w-full md:flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari judul modul, materi, atau topik..."
                           class="w-full pl-9 pr-4 py-2 glass-input text-xs sm:text-sm">
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto">
                    <!-- Kategori Filter -->
                    <select name="kategori" class="glass-input text-xs py-2 px-3 w-1/2 md:w-auto" onchange="this.form.submit()">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('kategori') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>

                    <!-- Tipe Filter -->
                    <select name="tipe" class="glass-input text-xs py-2 px-3 w-1/2 md:w-auto" onchange="this.form.submit()">
                        <option value="all" {{ request('tipe') === 'all' ? 'selected' : '' }}>Semua Format</option>
                        <option value="pdf" {{ request('tipe') === 'pdf' ? 'selected' : '' }}>Dokumen PDF (.pdf)</option>
                        <option value="ppt" {{ request('tipe') === 'ppt' ? 'selected' : '' }}>Presentasi Slide (.ppt / .pptx)</option>
                    </select>

                    @if(request()->anyFilled(['search', 'kategori', 'tipe']))
                        <a href="{{ route('trainer.modules.index') }}" class="p-2 rounded-xl bg-slate-100 dark:bg-surface-container-high text-slate-500 hover:text-red-600 transition-colors" title="Reset Filter">
                            <span class="material-symbols-outlined text-[18px]">refresh</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Modules Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($modules as $modul)
                <div class="rounded-3xl p-6 glass-panel glass-card-hover flex flex-col justify-between shadow-lg relative group">
                    <div class="space-y-3">
                        <!-- Top Badges & File Format -->
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{
                                $modul->isPdf()
                                    ? 'bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30'
                                    : 'bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30'
                            }}">
                                <span class="material-symbols-outlined text-[16px]">{{ $modul->icon }}</span>
                                <span>{{ strtoupper($modul->file_type) }}</span>
                            </span>

                            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-surface-variant text-slate-600 dark:text-on-surface-variant">
                                {{ $modul->kategori }}
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <div>
                            <h3 class="font-headline text-base md:text-lg font-bold text-slate-800 dark:text-on-surface leading-snug group-hover:text-red-600 transition-colors">
                                {{ $modul->judul }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-on-surface-variant mt-1.5 line-clamp-3 leading-relaxed">
                                {{ $modul->deskripsi ?? 'Tidak ada ringkasan deskripsi materi.' }}
                            </p>
                        </div>

                        <!-- Session Relation if any -->
                        @if($modul->training)
                            <div class="p-2.5 rounded-xl bg-red-500/5 dark:bg-surface-container/60 border border-red-500/15 text-[11px] text-slate-600 dark:text-on-surface-variant flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-red-500 shrink-0">calendar_month</span>
                                <span class="truncate">Sesi: <strong>{{ $modul->training->judul }}</strong></span>
                            </div>
                        @endif

                        <!-- Metadata Info -->
                        <div class="pt-2 border-t border-slate-200/50 dark:border-white/10 flex items-center justify-between text-[11px] text-slate-400">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">sd_storage</span>
                                <span>{{ $modul->formatted_file_size }}</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">download</span>
                                <span>{{ $modul->downloads_count }}x diunduh</span>
                            </span>
                        </div>
                    </div>

                    <!-- Bottom Action Buttons: Direct In-Website View + Download + Delete -->
                    <div class="mt-5 pt-4 border-t border-slate-200/50 dark:border-white/10 flex items-center gap-2">
                        <!-- Primary: View Directly in Website -->
                        <button type="button"
                                @click="openViewer({
                                    id: {{ $modul->id }},
                                    judul: '{{ addslashes($modul->judul) }}',
                                    deskripsi: '{{ addslashes($modul->deskripsi ?? '') }}',
                                    kategori: '{{ addslashes($modul->kategori) }}',
                                    tipe: '{{ $modul->file_type }}',
                                    isPdf: {{ $modul->isPdf() ? 'true' : 'false' }},
                                    size: '{{ $modul->formatted_file_size }}',
                                    trainer: '{{ addslashes($modul->trainer->name) }}',
                                    previewUrl: '{{ route('trainer.modules.preview', $modul->id) }}',
                                    downloadUrl: '{{ route('trainer.modules.download', $modul->id) }}'
                                })"
                                class="flex-1 py-2.5 px-3 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-700 hover:to-rose-700 text-white font-semibold text-xs flex items-center justify-center gap-1.5 shadow-md shadow-red-600/25 transition-all">
                            <span class="material-symbols-outlined text-[17px]">visibility</span>
                            <span>Lihat Modul</span>
                        </button>

                        <!-- Download Icon Button -->
                        <a href="{{ route('trainer.modules.download', $modul->id) }}"
                           class="p-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high hover:bg-red-500/10 text-slate-500 hover:text-red-600 transition-all shrink-0"
                           title="Unduh Berkas">
                            <span class="material-symbols-outlined text-[18px]">download</span>
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('trainer.modules.destroy', $modul->id) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high hover:bg-rose-500/15 hover:text-rose-500 text-slate-400 transition-all shrink-0"
                                    title="Hapus Modul">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center glass-panel rounded-3xl text-slate-400">
                    <span class="material-symbols-outlined text-5xl mb-2 text-slate-300 dark:text-outline/40">folder_open</span>
                    <p class="font-semibold text-sm">Belum ada modul pelatihan yang diunggah.</p>
                    <p class="text-xs text-slate-500 mt-1">Klik tombol "Unggah Modul Baru" untuk menambahkan materi presentasi PPT atau dokumen PDF.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $modules->links() }}
        </div>

        <!-- Direct In-Website Reader / Viewer Modal -->
        <div x-show="showViewerModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4 md:p-6 bg-slate-950/80 backdrop-blur-md">
            
            <div @click.outside="showViewerModal = false"
                 class="w-full max-w-6xl h-[92vh] glass-modal rounded-3xl flex flex-col overflow-hidden shadow-2xl border border-red-500/20">
                
                <!-- Viewer Header -->
                <div class="px-5 py-3.5 bg-slate-900/90 border-b border-slate-700/60 flex items-center justify-between gap-4 shrink-0 text-white">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 font-bold text-xs"
                              :class="activeModul.isPdf ? 'bg-rose-500/20 text-rose-400 border border-rose-500/40' : 'bg-amber-500/20 text-amber-400 border border-amber-500/40'">
                            <span class="material-symbols-outlined text-[20px]" x-text="activeModul.isPdf ? 'picture_as_pdf' : 'co_present'"></span>
                        </span>
                        <div class="min-w-0">
                            <h3 class="font-headline font-bold text-sm sm:text-base truncate text-white" x-text="activeModul.judul"></h3>
                            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                <span x-text="`Kategori: ${activeModul.kategori}`"></span>
                                <span>&bull;</span>
                                <span x-text="`Instruktur: ${activeModul.trainer}`"></span>
                                <span>&bull;</span>
                                <span x-text="activeModul.size"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Viewer Actions Toolbar -->
                    <div class="flex items-center gap-2 shrink-0">
                        <a :href="activeModul.previewUrl" target="_blank"
                           class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200 transition-all"
                           title="Buka di Tab Baru">
                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            <span>Tab Baru</span>
                        </a>

                        <a :href="activeModul.downloadUrl"
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-600 hover:bg-red-700 text-xs font-semibold text-white shadow-sm transition-all"
                           title="Unduh Berkas">
                            <span class="material-symbols-outlined text-[16px]">download</span>
                            <span class="hidden sm:inline">Unduh</span>
                        </a>

                        <button @click="showViewerModal = false"
                                class="p-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-all ml-1">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                </div>

                <!-- Viewer Body -->
                <div class="flex-1 w-full h-full bg-slate-950 overflow-hidden relative flex flex-col">
                    <!-- 1. PDF Direct Interactive Reader Frame -->
                    <template x-if="activeModul.isPdf">
                        <iframe :src="activeModul.previewUrl"
                                class="w-full h-full border-0 rounded-b-2xl"
                                title="Pratinjau Modul PDF"></iframe>
                    </template>

                    <!-- 2. PPT / PPTX Interactive Presentation Viewer -->
                    <template x-if="!activeModul.isPdf">
                        <div class="flex-1 flex flex-col justify-between p-6 md:p-10 text-white relative overflow-y-auto">
                            <!-- Background Glow Accent -->
                            <div class="absolute -top-20 -right-20 w-80 h-80 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>

                            <!-- Presentation Slide Header Card -->
                            <div class="max-w-4xl mx-auto w-full space-y-6 my-auto">
                                <div class="p-6 md:p-8 rounded-3xl bg-slate-900/90 border border-slate-700/60 shadow-2xl relative overflow-hidden">
                                    <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                            <span class="text-xs uppercase font-bold tracking-wider text-slate-400 ml-2">TalentTrack Slide Viewer Mode</span>
                                        </div>
                                        <span class="text-xs px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-400 font-bold uppercase"
                                              x-text="activeModul.tipe"></span>
                                    </div>

                                    <div class="py-6 space-y-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-400"
                                              x-text="activeModul.kategori"></span>
                                        <h2 class="font-headline text-2xl md:text-3xl font-extrabold text-white leading-tight"
                                            x-text="activeModul.judul"></h2>
                                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl"
                                           x-text="activeModul.deskripsi"></p>
                                    </div>

                                    <!-- Slide Key Points Summary -->
                                    <div class="p-4 rounded-2xl bg-slate-800/60 border border-slate-700/60 space-y-2 text-xs">
                                        <div class="font-bold text-slate-200 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px] text-amber-400">tips_and_updates</span>
                                            <span>Pokok Bahasan & Ringkasan Materi:</span>
                                        </div>
                                        <ul class="list-disc list-inside space-y-1 text-slate-300 pl-1">
                                            <li>Materi disusun langsung oleh instruktur: <strong class="text-white" x-text="activeModul.trainer"></strong></li>
                                            <li>Format presentasi interaktif untuk sesi tatap muka dan pelatihan daring.</li>
                                            <li>Berisi diagram alur kerja, studi kasus industri, dan panduan praktik langsung.</li>
                                        </ul>
                                    </div>

                                    <!-- Actions inside Slide Deck View -->
                                    <div class="pt-6 mt-6 border-t border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-center gap-2 text-xs text-slate-400">
                                            <span class="material-symbols-outlined text-[16px] text-emerald-400">verified</span>
                                            <span>Slide siap ditinjau secara langsung</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <a :href="`https://docs.google.com/viewer?url=${encodeURIComponent(window.location.origin + activeModul.previewUrl)}&embedded=true`"
                                               target="_blank"
                                               class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-white flex items-center gap-2 transition-all">
                                                <span class="material-symbols-outlined text-[16px]">slideshow</span>
                                                <span>Buka di Google Slide Viewer</span>
                                            </a>
                                            <a :href="activeModul.downloadUrl"
                                               class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold text-xs flex items-center gap-2 shadow-lg shadow-red-600/30 transition-all">
                                                <span class="material-symbols-outlined text-[16px]">file_download</span>
                                                <span>Unduh File PPT Asli</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Upload Module Modal (Trainer) -->
        <div x-show="showUploadModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div @click.outside="showUploadModal = false" class="w-full max-w-lg glass-modal rounded-3xl p-6 md:p-8 shadow-2xl relative">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200/50 dark:border-white/10 mb-5">
                    <div class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-xl bg-red-500/15 text-red-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">upload_file</span>
                        </span>
                        <div>
                            <h3 class="font-headline font-bold text-base md:text-lg text-slate-800 dark:text-on-surface">Unggah Modul Pelatihan</h3>
                            <p class="text-[11px] text-slate-400">Format yang didukung: Presentasi PPT / PPTX dan Dokumen PDF</p>
                        </div>
                    </div>
                    <button @click="showUploadModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form action="{{ route('trainer.modules.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="judul" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Judul Modul Pelatihan *</label>
                        <input type="text" name="judul" id="judul" required placeholder="Contoh: Modul Arsitektur Web & RESTful API" class="w-full glass-input text-xs sm:text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kategori" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Kategori Bidang *</label>
                            <input type="text" name="kategori" id="kategori" required list="kategori-list" placeholder="Pilih / ketik kategori..." class="w-full glass-input text-xs sm:text-sm">
                            <datalist id="kategori-list">
                                <option value="Web Development">
                                <option value="UI/UX Design">
                                <option value="Persiapan Karir">
                                <option value="Soft Skill & Komunikasi">
                                <option value="Manajemen Proyek">
                                <option value="Database & Cloud">
                            </datalist>
                        </div>

                        <div>
                            <label for="training_id" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Terkait Sesi Pelatihan (Opsional)</label>
                            <select name="training_id" id="training_id" class="w-full glass-input text-xs sm:text-sm">
                                <option value="">-- Modul Mandiri (Umum) --</option>
                                @foreach($trainings as $t)
                                    <option value="{{ $t->id }}">{{ $t->tanggal->format('d/m/Y') }} - {{ $t->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Deskripsi & Pokok Bahasan</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Jelaskan ringkasan materi atau tujuan pembelajaran dari modul ini..." class="w-full glass-input text-xs sm:text-sm"></textarea>
                    </div>

                    <!-- File Upload Input (PPT or PDF) -->
                    <div class="p-4 rounded-2xl bg-red-500/10 border border-dashed border-red-500/30 text-center">
                        <label for="modul_file" class="cursor-pointer block">
                            <span class="material-symbols-outlined text-4xl text-red-500 mb-1">cloud_upload</span>
                            <span class="block text-xs font-bold text-slate-800 dark:text-on-surface">Pilih Berkas Modul (PDF / PPT / PPTX)</span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">Ukuran maksimal file: 25 MB</span>
                        </label>
                        <input type="file" name="modul_file" id="modul_file" required accept=".pdf,.ppt,.pptx" class="mt-2 text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                    </div>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-200/50 dark:border-white/10">
                        <button type="button" @click="showUploadModal = false" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-surface-container-high text-xs font-semibold text-slate-700 dark:text-on-surface">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white text-xs font-semibold shadow-md shadow-red-600/30 transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            <span>Unggah Modul</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
