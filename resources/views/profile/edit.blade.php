<x-layouts.app title="Profil Akun">
    <div class="flex flex-col gap-6" x-data="{
        avatarPreview: '{{ $user->avatar_url }}',
        previewImage(e) {
            const file = e.target.files[0];
            if (file) {
                this.avatarPreview = URL.createObjectURL(file);
            }
        }
    }">
        <!-- Header Banner -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-container/20 text-primary-container dark:text-tertiary mb-2">
                    <span class="material-symbols-outlined text-[16px] mr-1">manage_accounts</span>
                    Pengaturan Pengguna
                </span>
                <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                    Profil Akun Saya
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1">
                    Kelola data identitas, preferensi akun, kata sandi, serta berkas pencari kerja Anda.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3.5 py-1.5 rounded-full text-xs font-bold {{ $user->isTrainer() ? 'bg-secondary-container/20 text-secondary' : 'bg-primary-container/20 text-primary-container dark:text-tertiary' }}">
                    {{ $user->isTrainer() ? 'Akun Instruktur / Trainer' : 'Akun Peserta Pelatihan' }}
                </span>
            </div>
        </div>

        <!-- Form Update Profil -->
        <form action="{{ $user->isTrainer() ? route('trainer.profile.update') : route('member.profile.update') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Avatar & Identitas Singkat Card -->
            <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-lg flex flex-col sm:flex-row items-center gap-6">
                <div class="relative group">
                    <img :src="avatarPreview"
                         alt="{{ $user->name }}"
                         class="w-24 h-24 md:w-28 md:h-28 rounded-2xl object-cover ring-4 ring-primary-container/30 shadow-xl transition-all group-hover:opacity-80">
                    <label for="foto"
                           class="absolute inset-0 flex flex-col items-center justify-center bg-black/40 rounded-2xl text-white opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity text-xs font-semibold">
                        <span class="material-symbols-outlined text-2xl mb-1">photo_camera</span>
                        <span>Ubah Foto</span>
                    </label>
                    <input type="file" name="foto" id="foto" accept="image/*" @change="previewImage" class="hidden">
                </div>

                <div class="space-y-1 text-center sm:text-left">
                    <h2 class="font-headline text-xl md:text-2xl font-bold text-slate-800 dark:text-on-surface">
                        {{ $user->name }}
                    </h2>
                    <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant">
                        {{ $user->email }} • Terdaftar sejak {{ $user->created_at->format('d M Y') }}
                    </p>
                    <p class="text-[11px] text-slate-400 pt-1">
                        Klik foto profil di atas untuk mengganti foto akun (JPG/PNG maks. 2MB).
                    </p>
                </div>
            </div>

            <!-- Bagian 1: Pengaturan Akun Dasar & Keamanan -->
            <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-lg space-y-6">
                <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface flex items-center gap-2 border-b border-slate-200/50 dark:border-white/10 pb-3">
                    <span class="material-symbols-outlined text-primary-container">lock</span>
                    <span>Informasi Akun & Kata Sandi</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="w-full glass-input text-xs sm:text-sm">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Alamat Email *</label>
                        <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="w-full glass-input text-xs sm:text-sm">
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/70 dark:bg-surface-container-high/40 border border-slate-200/40 dark:border-white/5 space-y-3">
                    <span class="text-xs font-bold text-slate-700 dark:text-on-surface block">
                        Ganti Kata Sandi (Kosongkan jika tidak ingin mengubah)
                    </span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-500 mb-1">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-slate-500 mb-1">Ulangi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Khusus Member (Data Lengkap & CV) -->
            @if($user->isMember())
                <div class="p-6 md:p-8 rounded-3xl glass-panel shadow-lg space-y-6">
                    <h3 class="font-headline font-bold text-base text-slate-800 dark:text-on-surface flex items-center gap-2 border-b border-slate-200/50 dark:border-white/10 pb-3">
                        <span class="material-symbols-outlined text-primary-container">badge</span>
                        <span>Biodata & Dokumen Pencari Kerja</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label for="nik" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">NIK (16 Digit)</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik', $profile?->nik) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="no_hp" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $profile?->no_hp) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="w-full glass-input text-xs sm:text-sm">
                                <option value="L" {{ old('jenis_kelamin', $profile?->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $profile?->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="tempat_lahir" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $profile?->tempat_lahir) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $profile?->tanggal_lahir?->format('Y-m-d')) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="status_pernikahan" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Status Pernikahan</label>
                            <select name="status_pernikahan" id="status_pernikahan" class="w-full glass-input text-xs sm:text-sm">
                                <option value="Belum Menikah" {{ old('status_pernikahan', $profile?->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Menikah" {{ old('status_pernikahan', $profile?->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Alamat Domisili Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="2" class="w-full glass-input text-xs sm:text-sm">{{ old('alamat', $profile?->alamat) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="pendidikan_terakhir" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $profile?->pendidikan_terakhir) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="jurusan" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Jurusan / Program Studi</label>
                            <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan', $profile?->jurusan) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="skill" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Keahlian (Skills, pisahkan koma)</label>
                        <input type="text" name="skill" id="skill" value="{{ old('skill', $profile?->skill) }}" class="w-full glass-input text-xs sm:text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="bidang_minat" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Bidang / Posisi Minat</label>
                            <input type="text" name="bidang_minat" id="bidang_minat" value="{{ old('bidang_minat', $profile?->bidang_minat) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                        <div>
                            <label for="lokasi_minat" class="block text-xs font-semibold text-slate-700 dark:text-on-surface mb-1">Lokasi Kerja Minat</label>
                            <input type="text" name="lokasi_minat" id="lokasi_minat" value="{{ old('lokasi_minat', $profile?->lokasi_minat) }}" class="w-full glass-input text-xs sm:text-sm">
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-primary-container/10 border border-primary-container/20 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <label for="cv" class="block text-xs font-bold text-slate-800 dark:text-on-surface mb-1">Dokumen CV (PDF max 5MB)</label>
                            <input type="file" name="cv" id="cv" accept=".pdf" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                        </div>
                        @if($profile?->cv_path)
                            <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-surface-container-high text-xs font-semibold text-slate-700 dark:text-on-surface hover:underline flex items-center gap-1.5 shrink-0">
                                <span class="material-symbols-outlined text-[16px] text-rose-500">picture_as_pdf</span>
                                <span>Unduh CV Tersimpan</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Submit Button Bar -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ $user->isTrainer() ? route('trainer.dashboard') : route('member.dashboard') }}"
                   class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high text-slate-700 dark:text-on-surface text-xs md:text-sm font-semibold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-700 hover:to-rose-700 text-white font-headline font-bold text-xs md:text-sm shadow-lg shadow-red-600/30 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span>Simpan Perubahan Profil</span>
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>

