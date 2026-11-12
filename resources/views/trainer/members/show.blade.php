<x-layouts.app title="Detail Member - {{ $member->name }}">
    <div class="flex flex-col gap-8" x-data="{ activeTab: 'profil' }">
        <!-- Back Navigation & Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-on-surface-variant">
            <a href="{{ route('trainer.members.index') }}" class="hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Daftar Member</span>
            </a>
            <span>/</span>
            <span class="text-slate-800 dark:text-on-surface font-semibold">{{ $member->name }}</span>
        </div>

        @php
            $profile = $member->profile;
            $pct = $profile ? $profile->progress_percentage : 16;
        @endphp

        <!-- Member Header Card -->
        <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-xl relative overflow-hidden">
            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-primary-container/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-4 md:gap-6">
                    <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="w-16 h-16 md:w-24 md:h-24 rounded-2xl object-cover ring-4 ring-primary-container/30 shadow-lg">
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-headline text-xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                                {{ $member->name }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary-container/20 text-primary-container dark:text-tertiary">
                                {{ ucfirst(str_replace('_', ' ', $profile?->tahap_saat_ini ?? 'pendaftaran')) }}
                            </span>
                        </div>
                        <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant">
                            {{ $member->email }} • {{ $profile?->no_hp ?? '-' }} • NIK: {{ $profile?->nik ?? '-' }}
                        </p>
                        <p class="text-xs text-slate-600 dark:text-on-surface-variant font-medium">
                            {{ $profile?->pendidikan_terakhir ?? '-' }} ({{ $profile?->jurusan ?? '-' }})
                        </p>
                    </div>
                </div>

                <!-- Action Download CV & Placement Badge -->
                <div class="flex flex-wrap items-center gap-3">
                    @if($profile?->cv_path)
                        <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high hover:bg-slate-200 dark:hover:bg-surface-container-highest text-slate-700 dark:text-on-surface font-semibold text-xs md:text-sm flex items-center gap-2 shadow-sm transition-all">
                            <span class="material-symbols-outlined text-[18px] text-rose-500">picture_as_pdf</span>
                            <span>Download CV PDF</span>
                        </a>
                    @else
                        <span class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-surface-container text-xs text-slate-400">CV Belum Diunggah</span>
                    @endif

                    <div class="px-4 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-semibold flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">work</span>
                        <span>Status: {{ strtoupper($member->latestPlacement?->status ?? 'PROSES') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline Perjalanan Member + Stage Updater for Trainer -->
        <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-lg space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="font-headline text-lg font-bold text-slate-800 dark:text-on-surface">
                        Alur & Tahap Perjalanan Member
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant">Kemajuan saat ini: {{ $pct }}%</p>
                </div>

                <!-- Update Stage Form for Trainer -->
                <form action="{{ route('trainer.members.update-stage', $member->id) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    <label for="tahap" class="text-xs font-semibold text-slate-600 dark:text-on-surface-variant whitespace-nowrap">Ubah Tahap:</label>
                    <select name="tahap" id="tahap" class="glass-input text-xs py-1.5 px-3">
                        @foreach($stages as $key => $st)
                            <option value="{{ $key }}" {{ ($profile?->tahap_saat_ini ?? 'pendaftaran') == $key ? 'selected' : '' }}>
                                {{ $st['order'] }}. {{ $st['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-1.5 rounded-xl bg-primary-container text-white text-xs font-semibold hover:bg-red-700 shadow-md transition-all">
                        Simpan
                    </button>
                </form>
            </div>

            <x-progress-timeline :stages="$timelineStages" :currentStage="$profile?->tahap_saat_ini" />
        </div>

        <!-- Placement Update Quick Panel -->
        <div class="p-6 rounded-3xl glass-panel shadow-lg">
            <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-500">domain_add</span>
                <span>Pencatatan Penempatan Kerja Mitra</span>
            </h3>

            <form action="{{ route('trainer.members.update-placement', $member->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                @csrf
                <div class="lg:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Perusahaan Mitra</label>
                    <input type="text" name="perusahaan" required value="{{ old('perusahaan', $member->latestPlacement?->perusahaan) }}" placeholder="Nama PT / Instansi" class="w-full glass-input text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Posisi / Jabatan</label>
                    <input type="text" name="posisi" required value="{{ old('posisi', $member->latestPlacement?->posisi) }}" placeholder="Contoh: Web Developer" class="w-full glass-input text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Status Penempatan</label>
                    <select name="status" required class="w-full glass-input text-xs">
                        <option value="proses" {{ ($member->latestPlacement?->status ?? '') == 'proses' ? 'selected' : '' }}>Masih Proses</option>
                        <option value="ditempatkan" {{ ($member->latestPlacement?->status ?? '') == 'ditempatkan' ? 'selected' : '' }}>Resmi Ditempatkan</option>
                        <option value="selesai" {{ ($member->latestPlacement?->status ?? '') == 'selesai' ? 'selected' : '' }}>Kontrak Selesai</option>
                        <option value="batal" {{ ($member->latestPlacement?->status ?? '') == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-md transition-all">
                        Simpan Penempatan
                    </button>
                </div>
            </form>
        </div>

        <!-- Detail Tabs Navigation -->
        <div class="flex items-center gap-2 border-b border-slate-200/50 dark:border-white/10 pb-2">
            <button @click="activeTab = 'profil'"
                    :class="activeTab === 'profil' ? 'border-primary-container text-primary-container dark:text-primary font-bold border-b-2' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white'"
                    class="px-4 py-2 text-xs md:text-sm font-semibold transition-all">
                Biodata & Kompetensi
            </button>
            <button @click="activeTab = 'pelatihan'"
                    :class="activeTab === 'pelatihan' ? 'border-primary-container text-primary-container dark:text-primary font-bold border-b-2' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white'"
                    class="px-4 py-2 text-xs md:text-sm font-semibold transition-all">
                Riwayat Pelatihan ({{ $member->attendances->count() }})
            </button>
            <button @click="activeTab = 'interview'"
                    :class="activeTab === 'interview' ? 'border-primary-container text-primary-container dark:text-primary font-bold border-b-2' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white'"
                    class="px-4 py-2 text-xs md:text-sm font-semibold transition-all">
                Riwayat Interview ({{ $member->interviews->count() }})
            </button>
            <button @click="activeTab = 'catatan'"
                    :class="activeTab === 'catatan' ? 'border-primary-container text-primary-container dark:text-primary font-bold border-b-2' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white'"
                    class="px-4 py-2 text-xs md:text-sm font-semibold transition-all">
                Catatan Perkembangan ({{ $member->progressNotesAsMember->count() }})
            </button>
        </div>

        <!-- TAB 1: BIODATA & KOMPETENSI -->
        <div x-show="activeTab === 'profil'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 rounded-3xl glass-panel space-y-3">
                <h3 class="font-headline font-bold text-sm text-slate-800 dark:text-on-surface border-b border-slate-200/50 dark:border-white/10 pb-2">
                    Data Pribadi & Kontak
                </h3>
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <span class="text-slate-400 block">Tempat, Tgl Lahir</span>
                        <span class="font-semibold text-slate-800 dark:text-on-surface">{{ $profile?->tempat_lahir ?? '-' }}, {{ $profile?->tanggal_lahir?->format('d M Y') ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Jenis Kelamin</span>
                        <span class="font-semibold text-slate-800 dark:text-on-surface">{{ $profile?->jenis_kelamin === 'L' ? 'Laki-laki' : ($profile?->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Status Pernikahan</span>
                        <span class="font-semibold text-slate-800 dark:text-on-surface">{{ $profile?->status_pernikahan ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Ekspektasi Gaji</span>
                        <span class="font-semibold text-slate-800 dark:text-on-surface">{{ $profile?->ekspektasi_gaji ?? '-' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 block">Alamat Domisili</span>
                        <span class="font-semibold text-slate-800 dark:text-on-surface">{{ $profile?->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-3xl glass-panel space-y-3">
                <h3 class="font-headline font-bold text-sm text-slate-800 dark:text-on-surface border-b border-slate-200/50 dark:border-white/10 pb-2">
                    Keahlian & Minat Karir
                </h3>
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block">Bidang & Posisi Minat</span>
                        <span class="font-semibold text-slate-800 dark:text-on-surface">{{ $profile?->bidang_minat ?? '-' }} (Lokasi: {{ $profile?->lokasi_minat ?? '-' }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Keahlian (Skills)</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(explode(',', (string)$profile?->skill) as $sk)
                                @if(trim($sk))
                                    <span class="px-2 py-0.5 rounded-lg bg-primary-container/15 text-primary-container dark:text-primary text-[11px] font-semibold">
                                        {{ trim($sk) }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Sertifikat</span>
                        <span class="font-semibold text-slate-800 dark:text-on-surface">{{ $profile?->sertifikat ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Pengalaman Kerja</span>
                        <p class="text-slate-600 dark:text-on-surface-variant leading-relaxed">{{ $profile?->pengalaman_kerja ?? 'Fresh graduate / Belum ada pengalaman.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: RIWAYAT PELATIHAN -->
        <div x-show="activeTab === 'pelatihan'" style="display: none;" class="rounded-3xl p-6 glass-panel">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/50 dark:border-white/10 text-xs text-slate-400">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Materi Pelatihan</th>
                            <th class="py-3 px-4">Kehadiran</th>
                            <th class="py-3 px-4">Nilai</th>
                            <th class="py-3 px-4">Catatan Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($member->attendances as $att)
                            <tr>
                                <td class="py-3 px-4 whitespace-nowrap">{{ $att->training->tanggal->format('d M Y') }}</td>
                                <td class="py-3 px-4 font-semibold text-slate-800 dark:text-on-surface">{{ $att->training->judul }}</td>
                                <td class="py-3 px-4"><x-badge-status :status="$att->status_kehadiran" /></td>
                                <td class="py-3 px-4 font-bold">{{ $att->nilai ? $att->nilai . '/100' : '-' }}</td>
                                <td class="py-3 px-4 text-xs text-slate-500">{{ $att->catatan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-6 text-center text-slate-400">Belum ada rekaman kehadiran pelatihan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 3: RIWAYAT INTERVIEW -->
        <div x-show="activeTab === 'interview'" style="display: none;" class="rounded-3xl p-6 glass-panel">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/50 dark:border-white/10 text-xs text-slate-400">
                            <th class="py-3 px-4">Perusahaan</th>
                            <th class="py-3 px-4">Posisi</th>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Konfirmasi Peserta</th>
                            <th class="py-3 px-4">Hasil Seleksi</th>
                            <th class="py-3 px-4">Feedback</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($member->interviews as $inv)
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-800 dark:text-on-surface">{{ $inv->perusahaan }}</td>
                                <td class="py-3 px-4 text-primary-container dark:text-primary font-semibold">{{ $inv->posisi }}</td>
                                <td class="py-3 px-4 whitespace-nowrap">{{ $inv->tanggal->format('d M Y') }} {{ substr($inv->jam, 0, 5) }}</td>
                                <td class="py-3 px-4"><x-badge-status :status="$inv->confirmation?->status ?? 'menunggu'" /></td>
                                <td class="py-3 px-4"><x-badge-status :status="$inv->hasil" /></td>
                                <td class="py-3 px-4 text-xs text-slate-500">{{ $inv->feedback ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-6 text-center text-slate-400">Belum ada agenda interview untuk member ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 4: CATATAN PERKEMBANGAN -->
        <div x-show="activeTab === 'catatan'" style="display: none;" class="space-y-6">
            <!-- Add Note Form -->
            <div class="p-6 rounded-3xl glass-panel shadow-sm">
                <h3 class="font-headline font-bold text-sm text-slate-800 dark:text-on-surface mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-container">edit_note</span>
                    <span>Tambah Catatan Evaluasi Baru untuk {{ $member->name }}</span>
                </h3>
                <form action="{{ route('trainer.members.add-note', $member->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <textarea name="catatan" rows="3" required placeholder="Tuliskan catatan perkembangan teknis, soft skill, atau saran persiapan interview..." class="w-full glass-input text-xs sm:text-sm"></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-container text-white text-xs font-semibold shadow-md hover:bg-red-700 transition-all">
                            Simpan Catatan ke Buku Saku
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notes List -->
            <div class="space-y-3">
                @forelse($member->progressNotesAsMember as $note)
                    <div class="p-5 rounded-2xl glass-panel space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-800 dark:text-on-surface">{{ $note->trainer->name }}</span>
                            <span class="text-slate-400">{{ $note->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-on-surface-variant leading-relaxed">
                            "{{ $note->catatan }}"
                        </p>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs">Belum ada catatan evaluasi untuk member ini.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>

