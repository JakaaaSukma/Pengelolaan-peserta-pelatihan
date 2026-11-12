<x-layouts.app title="Kelola Interview">
    <div class="flex flex-col gap-6" x-data="{
        showCreateModal: false,
        showResultModal: false,
        selectedInterviewId: null,
        selectedCompany: '',
        selectedCandidate: '',
        currentHasil: 'belum_ada',
        currentFeedback: '',
        openResultModal(id, candidate, company, hasil, feedback) {
            this.selectedInterviewId = id;
            this.selectedCandidate = candidate;
            this.selectedCompany = company;
            this.currentHasil = hasil || 'belum_ada';
            this.currentFeedback = feedback || '';
            this.showResultModal = true;
        }
    }">
        <!-- Header -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/15 text-red-600 dark:text-rose-400 mb-2">
                    <span class="material-symbols-outlined text-[16px] mr-1">contact_mail</span>
                    Penyaluran Kerja
                </span>
                <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                    Kelola Jadwal & Hasil Interview
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1">
                    Jadwalkan wawancara mitra korporat, pantau konfirmasi kehadiran peserta secara live, serta catat hasil & feedback seleksi.
                </p>
            </div>

            <button type="button"
                    @click="showCreateModal = true"
                    class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold text-xs md:text-sm flex items-center gap-2 shadow-lg shadow-red-600/30 transition-all">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Jadwalkan Interview Baru</span>
            </button>
        </div>

        <!-- Interviews Table -->
        <div class="rounded-3xl glass-panel shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200/50 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-on-surface-variant bg-slate-50/50 dark:bg-surface-container-highest/20">
                            <th class="py-4 px-6">Kandidat Member</th>
                            <th class="py-4 px-4">Perusahaan & Posisi</th>
                            <th class="py-4 px-4">Jadwal & Metode</th>
                            <th class="py-4 px-4">Konfirmasi Member</th>
                            <th class="py-4 px-4">Hasil Seleksi</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs sm:text-sm">
                        @forelse($interviews as $inv)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-surface-container-high/40 transition-colors">
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $inv->member->avatar_url }}" alt="{{ $inv->member->name }}" class="w-9 h-9 rounded-xl object-cover">
                                        <div>
                                            <a href="{{ route('trainer.members.show', $inv->member_id) }}" class="font-bold text-slate-800 dark:text-on-surface hover:text-primary-container transition-colors block">
                                                {{ $inv->member->name }}
                                            </a>
                                            <span class="text-[11px] text-slate-400">{{ $inv->member->profile?->jurusan ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-bold text-slate-800 dark:text-on-surface block">{{ $inv->perusahaan }}</span>
                                    <span class="text-xs text-primary-container dark:text-primary font-semibold">{{ $inv->posisi }}</span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-slate-600 dark:text-on-surface-variant">
                                    <span class="font-medium block text-slate-800 dark:text-on-surface">{{ $inv->tanggal->format('d M Y') }} - {{ substr($inv->jam, 0, 5) }} WIB</span>
                                    <div class="mt-0.5"><x-badge-status :status="$inv->tipe" /></div>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-badge-status :status="$inv->confirmation?->status ?? 'menunggu'" />
                                    @if($inv->confirmation && $inv->confirmation->alasan)
                                        <span class="block text-[11px] text-slate-400 truncate max-w-[140px]" title="{{ $inv->confirmation->alasan }}">
                                            "{{ $inv->confirmation->alasan }}"
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-badge-status :status="$inv->hasil" />
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-right space-x-1">
                                    <button type="button"
                                            @click="openResultModal({{ $inv->id }}, '{{ addslashes($inv->member->name) }}', '{{ addslashes($inv->perusahaan) }}', '{{ $inv->hasil }}', '{{ addslashes($inv->feedback ?? '') }}')"
                                            class="px-3 py-1.5 rounded-xl bg-primary-container/15 hover:bg-primary-container hover:text-white text-primary-container dark:text-primary text-xs font-semibold transition-all">
                                        Update Hasil
                                    </button>

                                    <form action="{{ route('trainer.interviews.destroy', $inv->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus jadwal interview ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-xl text-rose-500 hover:bg-rose-500/10 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400 text-xs">
                                    Belum ada agenda interview kerja yang dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($interviews->hasPages())
                <div class="p-4 border-t border-slate-200/50 dark:border-white/10">
                    {{ $interviews->links() }}
                </div>
            @endif
        </div>

        <!-- Create Interview Modal -->
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
                 x-data="{ tipe: 'online' }">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200/50 dark:border-white/10 mb-4">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface">Jadwalkan Wawancara Kerja Baru</h3>
                    <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form action="{{ route('trainer.interviews.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="member_id" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Pilih Kandidat Member *</label>
                        <select name="member_id" id="member_id" required class="w-full glass-input text-xs sm:text-sm">
                            <option value="">-- Pilih Peserta Pelatihan --</option>
                            @foreach($members as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->profile?->jurusan ?? 'Peserta' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="perusahaan" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Perusahaan Mitra *</label>
                            <input type="text" name="perusahaan" id="perusahaan" required placeholder="Contoh: PT Astra International" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="posisi" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Posisi / Jabatan *</label>
                            <input type="text" name="posisi" id="posisi" required placeholder="Contoh: Junior Developer" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="tanggal" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tanggal *</label>
                            <input type="date" name="tanggal" id="tanggal" required class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="jam" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Jam Wawancara *</label>
                            <input type="time" name="jam" id="jam" required value="10:00" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="tipe" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tipe Interview *</label>
                        <select name="tipe" id="tipe" x-model="tipe" required class="w-full glass-input text-xs sm:text-sm">
                            <option value="online">Online (Google Meet / Zoom)</option>
                            <option value="offline">Offline (Tatap Muka di Lokasi Kantor)</option>
                        </select>
                    </div>

                    <div x-show="tipe === 'online'">
                        <label for="link" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tautan Link Video Conference</label>
                        <input type="url" name="link" id="link" placeholder="https://meet.google.com/xyz" class="w-full glass-input text-xs sm:text-sm">
                    </div>

                    <div x-show="tipe === 'offline'" style="display: none;">
                        <label for="lokasi" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Alamat Kantor / Lokasi Interview</label>
                        <input type="text" name="lokasi" id="lokasi" placeholder="Gedung Menara X lt. 10, Jakarta" class="w-full glass-input text-xs sm:text-sm">
                    </div>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-200/50 dark:border-white/10">
                        <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-surface-container-high text-xs font-semibold text-slate-700 dark:text-on-surface">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-container text-white text-xs font-semibold shadow-md hover:bg-red-700 transition-all">
                            Simpan & Notifikasi Member
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Result Modal -->
        <div x-show="showResultModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div @click.outside="showResultModal = false" class="w-full max-w-md glass-modal rounded-3xl p-6 shadow-2xl relative">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200/50 dark:border-white/10 mb-4">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface">Pembaruan Hasil Interview</h3>
                    <button @click="showResultModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form :action="`/trainer/interviews/${selectedInterviewId}/result`" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <span class="text-xs text-slate-400 block">Kandidat:</span>
                        <strong class="text-sm text-slate-800 dark:text-on-surface" x-text="`${selectedCandidate} - ${selectedCompany}`"></strong>
                    </div>

                    <div>
                        <label for="hasil" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Hasil Seleksi Wawancara *</label>
                        <select name="hasil" id="hasil" x-model="currentHasil" required class="w-full glass-input text-xs sm:text-sm">
                            <option value="belum_ada">Belum Ada Keputusan</option>
                            <option value="menunggu_hasil">Sedang Menunggu Hasil</option>
                            <option value="lolos">Lolos (Diterima / Offering)</option>
                            <option value="tidak_lolos">Tidak Lolos</option>
                        </select>
                    </div>

                    <div>
                        <label for="feedback" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Feedback Rekruter / Evaluasi</label>
                        <textarea name="feedback" id="feedback" x-model="currentFeedback" rows="4" placeholder="Masukan dan evaluasi wawancara untuk buku saku kandidat..." class="w-full glass-input text-xs sm:text-sm"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-200/50 dark:border-white/10">
                        <button type="button" @click="showResultModal = false" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-surface-container-high text-xs font-semibold text-slate-700 dark:text-on-surface">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-container text-white text-xs font-semibold shadow-md hover:bg-red-700 transition-all">
                            Simpan Hasil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>

