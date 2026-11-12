# Sistem Monitoring Member Pelatihan Kerja (TalentTrack)

Sistem web terpadu berbasis **Laravel 10.x**, **Tailwind CSS 3.x**, dan **Alpine.js v3** untuk memantau perjalanan peserta (member) lembaga pelatihan kerja dari tahap awal pendaftaran hingga penempatan kerja di mitra industri/korporat.

---

## 🎯 Fitur Utama

### 1. Akun & Autentikasi
* Halaman login tunggal dengan toggle **Masuk sebagai Member / Trainer**
* Tombol **Isi Otomatis Akun Demo** untuk login instan dengan satu klik
* Middleware proteksi peran (`role:member` dan `role:trainer`)
* Pengalihan otomatis (*automatic redirect*) ke alur Onboarding bagi member baru yang belum melengkapi profil
* Halaman **Profil Akun** (`/profile`) untuk mengubah nama, email, foto avatar, kata sandi, dan dokumen CV

### 2. Alur Perjalanan Member (Timeline 6 Tahap)
Progress tracker interaktif:
1. **Pendaftaran** (16%)
2. **Melengkapi Data** (33%)
3. **Pelatihan Vokasi** (50%)
4. **Evaluasi Kompetensi** (66%)
5. **Interview Mitra Industri** (83%)
6. **Penempatan Kerja** (100%)

### 3. Fitur untuk Member (Peserta)
* **Onboarding Data Pencari Kerja:** Multi-step form (Data Pribadi, Pendidikan & Pengalaman, Keahlian & Sertifikat, Minat Karir & Berkas CV)
* **Dashboard Member:** Ringkasan capaian, pelatihan terdekat, interview terdekat, dan notifikasi
* **Katalog Modul Pelatihan (PPT / PDF):** Cari, filter berdasarkan kategori/format file, dan unduh slide materi presentasi (PPT/PPTX) serta modul teknis (PDF) dari instruktur
* **Buku Saku Digital:** Counter pelatihan & interview, riwayat kehadiran, nilai evaluasi instruktur, feedback mitra, serta 4 lencana prestasi (*badges*)
* **Jadwal Pelatihan:** Filter Tatap Muka (Offline) dengan modal peta lokasi / Webinar (Online) dengan tautan langsung meeting room dan modul terlampir
* **Jadwal Interview & Konfirmasi Kehadiran:** Hitung mundur (*countdown timer*) dan aksi konfirmasi:
  * `[Hadir]` (Konfirmasi langsung)
  * `[Tidak Hadir]` (Wajib mengisi alasan)
  * `[Minta Reschedule]` (Wajib mengisi alasan)

### 4. Fitur untuk Trainer (Instruktur)
* **Dashboard Trainer:** Statistik total member, member aktif, interview minggu ini, rasio penempatan kerja, serta grafik visual pipeline tahapan
* **Daftar Member:** Tabel dengan pencarian (nama/email/jurusan/skill), filter tahapan, dan pagination
* **Detail & Evaluasi Member:** Profil lengkap, unduh CV, perbarui tahap alur perjalanan, tambah catatan perkembangan, dan input status penempatan kerja
* **Kelola Pelatihan (CRUD):** Tambah jadwal workshop offline/online dan rekap absensi masal beserta nilai evaluasi
* **Kelola Modul Pelatihan (CRUD PPT / PDF):** Unggah berkas modul presentasi PowerPoint (.ppt, .pptx) atau dokumen panduan (.pdf) berkapasitas hingga 25 MB, terhubung dengan sesi pelatihan atau mandiri
* **Kelola Interview (CRUD):** Jadwalkan interview untuk member, pantau konfirmasi kehadiran secara live, dan update hasil seleksi (Lolos/Tidak Lolos) + feedback

---

## 🔑 Akun Demo Siap Pakai

| Peran (Role) | Email | Password |
| :--- | :--- | :--- |
| **Trainer / Instruktur** | `trainer@demo.com` | `password` |
| **Member / Peserta** | `member@demo.com` | `password` |

---

## 💻 Panduan Instalasi & Menjalankan Lokal

### Prasyarat
1. **PHP:** Versi 8.1 atau 8.2 (aktif di XAMPP)
2. **MySQL / MariaDB:** Aktif di port `3306` (via XAMPP)
3. **Composer:** Versi 2.x
4. **Node.js & npm:** Node v18+ / v20+

### Langkah Menjalankan:
```bash
# 1. Clone repository
git clone https://github.com/USERNAME/REPO-NAME.git
cd REPO-NAME/monitoring-pelatihan

# 2. Instal dependensi PHP (Composer) & Node.js (npm)
composer install
npm install
npm run build

# 3. Konfigurasi Environment
cp .env.example .env
php artisan key:generate

# 4. Siapkan database MySQL (buat database 'monitoring_pelatihan' di phpMyAdmin/MySQL)
# Sesuaikan DB_USERNAME & DB_PASSWORD di .env jika diperlukan

# 5. Jalankan migrasi tabel beserta data demo
php artisan migrate --seed

# 6. Buat symbolic link storage berkas (CV, modul PDF/PPT, foto profil)
php artisan storage:link

# 7. Jalankan server lokal Laravel
php artisan serve
```

Aplikasi dapat langsung diakses melalui:
* **Aplikasi Web:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
* **Portal Navigasi XAMPP:** [http://localhost/Kelola%20Member/](http://localhost/Kelola%20Member/)

---

## 🎨 Desain: Red Theme Glassmorphism Ultra-Ringan
* **Akselerasi GPU & Zero-Lag:** Menggunakan CSS `radial-gradient` statis ber-akselerasi GPU (`background-attachment: fixed`) yang menghilangkan 100% beban repainting 60fps, sehingga CPU/GPU tetap dingin dan responsif.
* **Palet Dominan Merah:** Corporate Ruby (`#dc2626`), Rich Deep Crimson (`#991b1b`), Coral Rose (`#fb7185`), dan latar gelap Obsidian (`#0d090b`).
* **Frosted Glass:** Backdrop blur tingkat `md` dengan kontras teks tinggi (*high contrast accessibility*).
* **Mode Gelap & Terang:** Toggle instan yang tersimpan otomatis di `localStorage`.
