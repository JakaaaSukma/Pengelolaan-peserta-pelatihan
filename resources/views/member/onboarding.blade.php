<x-layouts.auth title="Lengkapi Data Pencari Kerja">
    <div class="w-full max-w-3xl my-6" x-data="{
        step: 1,
        totalSteps: 4,
        nextStep() {
            if (this.step === 1) {
                if (!document.getElementById('nik').value || !document.getElementById('tempat_lahir').value || !document.getElementById('tanggal_lahir').value || !document.getElementById('no_hp').value || !document.getElementById('alamat').value) {
                    $store.toast.notify('Harap lengkapi semua kolom wajib di Tahap 1!', 'error');
                    return;
                }
            }
            if (this.step === 2) {
                if (!document.getElementById('pendidikan_terakhir').value || !document.getElementById('jurusan').value) {
                    $store.toast.notify('Harap isi pendidikan terakhir & jurusan di Tahap 2!', 'error');
                    return;
                }
            }
            if (this.step === 3) {
                if (!document.getElementById('skill').value) {
                    $store.toast.notify('Harap sebutkan keahlian / skill Anda di Tahap 3!', 'error');
                    return;
                }
            }
            if (this.step < this.totalSteps) {
                this.step++;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        prevStep() {
            if (this.step > 1) {
                this.step--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    }">
        <div class="glass-panel rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden">
            <!-- Header Progress -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-container/20 text-primary-container dark:text-tertiary">
                        <span class="w-2 h-2 rounded-full bg-primary-container mr-2 animate-ping"></span>
                        Onboarding Member Baru
                    </span>
                    <span class="text-xs font-bold text-slate-500 dark:text-on-surface-variant" x-text="`Langkah ${step} dari ${totalSteps}`"></span>
                </div>

                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                    Lengkapi Profil Pencari Kerja
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-on-surface-variant mt-1">
                    Data Anda akan digunakan oleh instruktur untuk pemetaan kompetensi dan penyaluran kerja ke mitra industri.
                </p>

                <!-- Step Progress Bar -->
                <div class="w-full bg-slate-200 dark:bg-surface-variant h-2.5 rounded-full overflow-hidden mt-6">
                    <div class="bg-gradient-to-r from-primary-container via-secondary-container to-tertiary h-full transition-all duration-500 ease-out rounded-full"
                         :style="`width: ${(step / totalSteps) * 100}%`"></div>
                </div>

                <!-- Step Indicator Labels -->
                <div class="grid grid-cols-4 gap-2 mt-3 text-center text-[11px] font-semibold">
                    <span :class="step >= 1 ? 'text-primary-container dark:text-primary' : 'text-slate-400 dark:text-outline'">1. Biodata Pribadi</span>
                    <span :class="step >= 2 ? 'text-primary-container dark:text-primary' : 'text-slate-400 dark:text-outline'">2. Pendidikan</span>
                    <span :class="step >= 3 ? 'text-primary-container dark:text-primary' : 'text-slate-400 dark:text-outline'">3. Keahlian</span>
                    <span :class="step >= 4 ? 'text-primary-container dark:text-primary' : 'text-slate-400 dark:text-outline'">4. Minat & Berkas</span>
                </div>
            </div>

            <!-- Errors Alert -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs">
                    <p class="font-bold mb-1">Terdapat kesalahan pada formulir:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Multi-Step -->
            <form action="{{ route('member.onboarding.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- STEP 1: DATA PRIBADI -->
                <div x-show="step === 1" x-transition class="space-y-5">
                    <h2 class="text-base font-bold text-slate-800 dark:text-on-surface pb-2 border-b border-slate-200/50 dark:border-white/10 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">badge</span>
                        <span>1. Data Pribadi</span>
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full glass-input opacity-75 cursor-not-allowed text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="nik" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">NIK (16 Digit) *</label>
                            <input type="text" name="nik" id="nik" maxlength="20" required value="{{ old('nik', $profile?->nik) }}" placeholder="3273xxxxxxxxxxxx" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="tempat_lahir" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tempat Lahir *</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" required value="{{ old('tempat_lahir', $profile?->tempat_lahir) }}" placeholder="Kota Kelahiran" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" required value="{{ old('tanggal_lahir', $profile?->tanggal_lahir?->format('Y-m-d')) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full glass-input text-xs sm:text-sm">
                                <option value="L" {{ old('jenis_kelamin', $profile?->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $profile?->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_pernikahan" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Status Pernikahan *</label>
                            <select name="status_pernikahan" id="status_pernikahan" required class="w-full glass-input text-xs sm:text-sm">
                                <option value="Belum Menikah" {{ old('status_pernikahan', $profile?->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Menikah" {{ old('status_pernikahan', $profile?->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                            </select>
                        </div>
                        <div>
                            <label for="no_hp" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">No. HP / WhatsApp *</label>
                            <input type="text" name="no_hp" id="no_hp" required value="{{ old('no_hp', $profile?->no_hp) }}" placeholder="08123456789" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="foto" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Foto Profil Resmi (JPG/PNG max 2MB)</label>
                            <input type="file" name="foto" id="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                        </div>
                    </div>
                    <div>
                        <label for="alamat" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Alamat Domisili Lengkap *</label>
                        <textarea name="alamat" id="alamat" rows="2" required placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota" class="w-full glass-input text-xs sm:text-sm">{{ old('alamat', $profile?->alamat) }}</textarea>
                    </div>
                </div>

                <!-- STEP 2: PENDIDIKAN & PENGALAMAN -->
                <div x-show="step === 2" x-transition style="display: none;" class="space-y-5">
                    <h2 class="text-base font-bold text-slate-800 dark:text-on-surface pb-2 border-b border-slate-200/50 dark:border-white/10 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">school</span>
                        <span>2. Riwayat Pendidikan & Pengalaman</span>
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="pendidikan_terakhir" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Pendidikan Terakhir *</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir" required class="w-full glass-input text-xs sm:text-sm">
                                <option value="">-- Pilih Pendidikan --</option>
                                <option value="SMK / SMA" {{ old('pendidikan_terakhir', $profile?->pendidikan_terakhir) == 'SMK / SMA' ? 'selected' : '' }}>SMK / SMA</option>
                                <option value="D3" {{ old('pendidikan_terakhir', $profile?->pendidikan_terakhir) == 'D3' ? 'selected' : '' }}>Diploma 3 (D3)</option>
                                <option value="D4 / S1" {{ old('pendidikan_terakhir', $profile?->pendidikan_terakhir) == 'D4 / S1' ? 'selected' : '' }}>Diploma 4 / Sarjana (D4 / S1)</option>
                                <option value="S2" {{ old('pendidikan_terakhir', $profile?->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                            </select>
                        </div>
                        <div>
                            <label for="jurusan" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Jurusan / Program Studi *</label>
                            <input type="text" name="jurusan" id="jurusan" required value="{{ old('jurusan', $profile?->jurusan) }}" placeholder="Contoh: Rekayasa Perangkat Lunak, Teknik Informatika" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="pengalaman_kerja" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Pengalaman Kerja / Magang (Opsional jika fresh graduate)</label>
                        <textarea name="pengalaman_kerja" id="pengalaman_kerja" rows="3" placeholder="Sebutkan nama perusahaan/instansi, posisi, durasi, dan tugas yang dikerjakan..." class="w-full glass-input text-xs sm:text-sm">{{ old('pengalaman_kerja', $profile?->pengalaman_kerja) }}</textarea>
                    </div>
                </div>

                <!-- STEP 3: KEAHLIAN & SERTIFIKAT -->
                <div x-show="step === 3" x-transition style="display: none;" class="space-y-5">
                    <h2 class="text-base font-bold text-slate-800 dark:text-on-surface pb-2 border-b border-slate-200/50 dark:border-white/10 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">psychology</span>
                        <span>3. Keahlian & Sertifikasi</span>
                    </h2>

                    <div>
                        <label for="skill" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Keahlian Utama (Hard Skill & Soft Skill) *</label>
                        <textarea name="skill" id="skill" rows="3" required placeholder="Contoh: Laravel, Tailwind CSS, JavaScript, MySQL, UI Design Figma, Problem Solving, Teamwork" class="w-full glass-input text-xs sm:text-sm">{{ old('skill', $profile?->skill) }}</textarea>
                        <span class="text-[11px] text-slate-400 dark:text-outline mt-1 block">Pisahkan setiap keahlian dengan tanda koma (,).</span>
                    </div>

                    <div>
                        <label for="sertifikat" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Sertifikat Kompetensi yang Dimiliki (Opsional)</label>
                        <textarea name="sertifikat" id="sertifikat" rows="2" placeholder="Contoh: BNSP Junior Web Developer (2023), Dicoding React Developer, TOEFL 550" class="w-full glass-input text-xs sm:text-sm">{{ old('sertifikat', $profile?->sertifikat) }}</textarea>
                    </div>
                </div>

                <!-- STEP 4: MINAT KARIR & UPLOAD CV -->
                <div x-show="step === 4" x-transition style="display: none;" class="space-y-5">
                    <h2 class="text-base font-bold text-slate-800 dark:text-on-surface pb-2 border-b border-slate-200/50 dark:border-white/10 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container">work</span>
                        <span>4. Minat Karir & Berkas Pendukung</span>
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="bidang_minat" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Bidang / Posisi yang Diminati *</label>
                            <input type="text" name="bidang_minat" id="bidang_minat" required value="{{ old('bidang_minat', $profile?->bidang_minat) }}" placeholder="Contoh: Web Developer, Frontend, UI Designer" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="lokasi_minat" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Lokasi Kerja yang Diminati *</label>
                            <input type="text" name="lokasi_minat" id="lokasi_minat" required value="{{ old('lokasi_minat', $profile?->lokasi_minat) }}" placeholder="Contoh: Bandung, Jakarta, Remote (WFA)" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="ekspektasi_gaji" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Ekspektasi Gaji Per Bulan (Opsional)</label>
                        <input type="text" name="ekspektasi_gaji" id="ekspektasi_gaji" value="{{ old('ekspektasi_gaji', $profile?->ekspektasi_gaji) }}" placeholder="Contoh: Rp 6.000.000 - Rp 8.000.000" class="w-full glass-input text-xs sm:text-sm">
                    </div>

                    <div class="p-4 rounded-2xl bg-primary-container/10 border border-primary-container/20">
                        <label for="cv" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Upload CV Terbaru (Format PDF, Maks. 5MB)</label>
                        <input type="file" name="cv" id="cv" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                        @if($profile?->cv_path)
                            <span class="text-[11px] text-emerald-600 dark:text-emerald-400 mt-2 block">✓ File CV Anda sudah tersimpan sebelumnya. Unggah kembali jika ingin mengganti.</span>
                        @endif
                    </div>
                </div>

                <!-- Step Navigation Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-200/50 dark:border-white/10 mt-8">
                    <button type="button"
                            @click="prevStep()"
                            x-show="step > 1"
                            class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high hover:bg-slate-200 dark:hover:bg-surface-container-highest text-slate-700 dark:text-on-surface font-semibold text-xs sm:text-sm flex items-center gap-1.5 transition-all">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        <span>Sebelumnya</span>
                    </button>

                    <div x-show="step === 1"></div>

                    <button type="button"
                            @click="nextStep()"
                            x-show="step < totalSteps"
                            class="ml-auto px-6 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold text-xs sm:text-sm shadow-md hover:scale-[1.02] active:scale-[0.98] flex items-center gap-1.5 transition-all">
                        <span>Lanjutkan</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>

                    <button type="submit"
                            x-show="step === totalSteps"
                            style="display: none;"
                            class="ml-auto px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-headline font-bold text-sm shadow-lg shadow-emerald-500/30 hover:scale-[1.02] active:scale-[0.98] flex items-center gap-2 transition-all">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        <span>Simpan & Masuk Dashboard</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>

