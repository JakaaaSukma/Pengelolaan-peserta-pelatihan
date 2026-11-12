# TalentTrack — Sistem Monitoring Member Pelatihan Kerja

<div align="center">

![TalentTrack Banner](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-emerald?style=for-the-badge)

<p align="center">
  <b>Sistem monitoring komprehensif, modern, dan ultra-ringan untuk memantau perjalanan peserta (member) lembaga pelatihan kerja mulai dari pendaftaran, pelatihan vokasi, evaluasi kompetensi, interview mitra industri, hingga penempatan kerja.</b>
</p>

[Fitur Utama](#-fitur-utama) • [Desain & Performa](#-desain--performa) • [Akun Demo](#-akun-demo) • [Panduan Instalasi](#-panduan-instalasi--setup-lokal) • [Keamanan](#-keamanan--kesiapan-publikasi-github)

</div>

---

## 🌟 Sorotan Pembaruan Terkini

* 🔴 **Desain Dominan Merah (Executive Crimson & Ruby Glassmorphism):** Palet warna visual tegas dan berkelas (`#dc2626`, `#991b1b`, `#e11d48`) berpadu dengan aksen kaca frosted glass berkontras tinggi (memenuhi standar aksesibilitas WCAG).
* ⚡ **Ultra-Ringan & Zero-Lag (Performa Tinggi):** Menggunakan mesh gradien statis berakselerasi GPU (`hardware-accelerated fixed rendering`) yang mengeliminasi 100% beban repainting CPU 60fps, menjamin sistem sangat responsif dan dingin bahkan pada perangkat berspesifikasi rendah.
* 🧭 **Navigasi Atas Fleksibel (Top Horizontal Header Bar):** Tata letak dashboard lapang dan modern tanpa sidebar samping yang memakan ruang, dilengkapi dropdown profil cepat dan drawer navigasi mobile.
* 📄 **Modul Pelatihan & In-Website Interactive Viewer:** 
  * Mendukung modul berformat presentasi **PowerPoint (.ppt, .pptx)** dan dokumen **PDF (.pdf)** hingga 25 MB.
  * **Lihat Langsung di Website:** Peserta dan instruktur dapat langsung membaca modul di dalam sistem secara interaktif tanpa harus mengunduh file terlebih dahulu (lengkap dengan zoom, fullscreen, dan slide navigasi).
* ✨ **Modern & Artistic Motion:** Animasi transisi bertahap (*staggered glide-up*), timeline progress line animated expansion, dan hover glow modern saat membuka setiap halaman.
* 👤 **Halaman Profil Akun Terintegrasi (`/profile`):** Manajemen akun mandiri, upload foto avatar dengan pratinjau langsung, ganti kata sandi, serta unduh dan perbarui berkas CV kerja.

---

## 🎯 Fitur Sistem

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                          ALUR PERJALANAN MEMBER                             │
│                                                                             │
│  [1. Pendaftaran] ➔ [2. Melengkapi Data] ➔ [3. Pelatihan]                   │
│          (16%)                 (33%)                 (50%)                  │
│                                  │                                          │
│                                  ▼                                          │
│  [6. Penempatan]  ◀─ [5. Interview]      ◀─ [4. Evaluasi]                   │
│         (100%)                 (83%)                 (66%)                  │
└─────────────────────────────────────────────────────────────────────────────┘
```

### 1. Autentikasi & Onboarding
* **Halaman Login Tunggal:** Dilengkapi toggle instan untuk memilih masuk sebagai **Member** atau **Trainer**.
* **1-Click Quick Demo Login:** Tombol pengisian otomatis kredensial demo untuk evaluasi cepat tanpa repot mengetik.
* **Middleware Berbasis Peran:** Pemisahan hak akses ketat (`role:member` dan `role:trainer`).
* **Onboarding Multi-Step Form:** Pengalihan otomatis bagi member baru untuk melengkapi:
  * Data pribadi (NIK, TTL, Jenis Kelamin, Status, Alamat, No. WhatsApp).
  * Pendidikan terakhir dan jurusan.
  * Pengalaman kerja, keahlian utama, dan sertifikasi.
  * Minat industri, target lokasi kerja, dan ekspektasi gaji.
  * Upload berkas CV (PDF/DOCX) dengan validasi tipe dan ukuran.

### 2. Fitur untuk Member (Peserta Pelatihan)
* **Dashboard Member:** Ringkasan capaian, persentase timeline perjalanan karir, jadwal pelatihan & interview terdekat, serta notifikasi masuk.
* **Buku Saku Digital:**
  * Penghitung total pelatihan yang diikuti dan total interview yang dijalani.
  * 4 Lencana Prestasi Otomatis (*First Step, Knowledge Seeker, Interview Ready, Hired Talent*).
  * Riwayat detail pelatihan, status absensi, dan nilai evaluasi dari instruktur.
  * Riwayat interview mitra, status hasil seleksi, dan catatan feedback perusahaan.
  * Catatan bimbingan dan perkembangan langsung dari instruktur (*trainer*).
* **Katalog Modul Pelatihan:**
  * Pencarian dan filter materi berdasarkan kategori atau format berkas (PDF / PPT / PPTX).
  * **Interactive Reader Modal:** Membaca modul langsung di dalam website tanpa wajib download.
  * Tombol unduh resmi untuk penyimpanan lokal.
* **Jadwal Pelatihan:**
  * Mode tampilan kartu interaktif.
  * Filter sesi **Tatap Muka (Offline)** dengan modal peta lokasi ruangan / **Webinar (Online)** dengan tautan langsung room meeting.
* **Jadwal Interview & Konfirmasi Kehadiran:**
  * Detail jadwal wawancara perusahaan mitra industri.
  * Countdown hitung mundur waktu menuju sesi interview.
  * **Aksi Konfirmasi Kehadiran Real-time:**
    * `[Hadir]` — Konfirmasi kesiapan mengikuti interview.
    * `[Tidak Hadir]` — Wajib menyertakan formulir alasan ketidakhadiran.
    * `[Minta Reschedule]` — Permohonan penjadwalan ulang dengan catatan alasan.

### 3. Fitur untuk Trainer (Instruktur & Pengelola)
* **Dashboard Trainer Analytics:**
  * Ringkasan statistik total member terdaftar, member aktif di kelas, jadwal interview minggu ini, dan rasio penempatan kerja.
  * Visualisasi pipeline tahapan seluruh peserta secara komprehensif.
* **Manajemen Peserta (Member):**
  * Tabel data member dengan fitur pencarian instan (nama, email, jurusan, keahlian), filter tahapan karir, dan pagination.
  * **Halaman Detail & Evaluasi Member:** Tinjauan portofolio lengkap, unduh CV, mutasi tahapan progress member, input catatan bimbingan, dan update status penempatan kerja (perusahaan & posisi).
* **Kelola Jadwal Pelatihan (CRUD):**
  * Pembuatan jadwal pelatihan (offline/online) beserta materi dan tautan ruangan.
  * Rekap absensi masal peserta sekaligus input skor nilai dan catatan evaluasi.
* **Kelola Modul Materi (CRUD):**
  * Unggah modul presentasi PowerPoint (.ppt, .pptx) atau dokumen panduan (.pdf) berkapasitas s.d. 25 MB.
  * Menghubungkan modul dengan jadwal pelatihan terkait atau materi umum.
* **Kelola Jadwal Interview (CRUD):**
  * Penjadwalan interview peserta dengan mitra industri.
  * Pantau status konfirmasi kehadiran member secara langsung (*Hadir / Tidak Hadir / Minta Reschedule*).
  * Input hasil wawancara (*Lolos / Tidak Lolos*) beserta feedback evaluasi untuk perbaikan peserta.

---

## 🎨 Desain & Performa

| Aspek | Implementasi |
| :--- | :--- |
| **Palet Warna** | *Executive Crimson & Ruby Red* (`#dc2626`, `#991b1b`, `#e11d48`) dipadukan dengan latar *Dark Obsidian Glass* (`#0f0a0c`). |
| **Gaya Desain** | Glassmorphism dengan border halus semi-transparan, backdrop blur teroptimasi, dan kontras teks tinggi (*high contrast*). |
| **Tipografi & Ikon** | Font modern **Plus Jakarta Sans** dan kumpulan ikon resmi **Google Material Symbols Outlined**. |
| **Arsitektur Performa** | **Zero-Lag GPU Acceleration** — bebas dari animasi loop berat yang menguras baterai/CPU. |
| **Motion & Efek** | *Modern Staggered Entrance Motion* saat pergantian halaman dan ekspansi garis timeline progress yang artistik. |
| **Dukungan Tema** | Mode Terang (*Light Mode*) dan Mode Gelap (*Dark Mode*) dengan penyimpanan status otomatis di `localStorage`. |

---

## 🔑 Akun Demo

Sistem telah dilengkapi dengan database seeder yang memuat data contoh realistis. Gunakan akun berikut untuk pengujian:

| Peran (Role) | Email | Password | Akses Fitur |
| :--- | :--- | :--- | :--- |
| **Trainer / Instruktur** | `trainer@demo.com` | `password` | Dashboard Trainer, Kelola Member, Kelola Pelatihan, Unggah Modul, Kelola Interview |
| **Member (Siap Interview)** | `member@demo.com` | `password` | Dashboard Member, Buku Saku, Modul Materi, Konfirmasi Interview BCA |
| **Member Tambahan 1** | `budi@demo.com` | `password` | Tahap Evaluasi Kompetensi |
| **Member Tambahan 2** | `citra@demo.com` | `password` | Tahap Pelatihan Vokasi |
| **Member Tambahan 3** | `dewi@demo.com` | `password` | Tahap Penempatan Kerja (*Hired*) |

> 💡 **Tips Cepat:** Di halaman login, Anda cukup mengklik tombol **"Gunakan Akun Demo Trainer"** atau **"Gunakan Akun Demo Member"** untuk login instan dengan satu klik.

---

## 💻 Panduan Instalasi & Setup Lokal

### Prasyarat Sistem
* **PHP:** Versi 8.1 atau 8.2 (ekstensi `pdo_mysql`, `mbstring`, `fileinfo`, `openssl` aktif)
* **Web Server & Database:** XAMPP / MariaDB / MySQL aktif di port default `3306`
* **Composer:** Versi 2.x
* **Node.js:** Versi 18+ atau 20+ (beserta `npm`)

### Langkah Instalasi

#### 1. Clone Repository
```bash
git clone <URL_REPOSITORY_ANDA>
cd monitoring-pelatihan
```

#### 2. Install Dependensi Backend (Composer)
```bash
composer install
```

#### 3. Install Dependensi Frontend (NPM)
```bash
npm install
```

#### 4. Konfigurasi Environment (`.env`)
Salin file template `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Buka file `.env` dan pastikan konfigurasi database sesuai dengan server MySQL lokal Anda (contoh untuk XAMPP default):
```env
APP_NAME=TalentTrack
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring_pelatihan
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Generate Application Key
```bash
php artisan key:generate
```

#### 6. Buat Database & Jalankan Migrasi + Seeder
Buat database baru bernama `monitoring_pelatihan` di phpMyAdmin (`http://localhost/phpmyadmin`), kemudian jalankan:
```bash
php artisan migrate --seed
```
> Database seeder secara otomatis membuat struktur tabel, data dummy realistis, serta file contoh modul (PDF & PPT) di direktori penyimpanan lokal.

#### 7. Buat Symbolic Link Storage
Agar berkas modul, CV, dan foto profil dapat diakses publik oleh aplikasi:
```bash
php artisan storage:link
```

#### 8. Build Aset Frontend
Jalankan salah satu perintah berikut:
```bash
# Untuk mode produksi (rekomendasi, bundle vite statis)
npm run build

# ATAU untuk mode pengembangan (hot-reload)
npm run dev
```

#### 9. Jalankan Server Aplikasi
```bash
php artisan serve
```

Aplikasi kini aktif dan dapat diakses melalui browser di:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 📂 Struktur Direktori Utama

```
monitoring-pelatihan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                     # Login, Logout, Onboarding Controller
│   │   │   ├── Member/                   # Dashboard, Modul, Buku Saku, Jadwal, Interview
│   │   │   ├── Trainer/                  # Dashboard, Member, Pelatihan, Modul, Interview
│   │   │   └── ProfileController.php     # Manajemen Akun & Foto Profil
│   │   └── Middleware/
│   │       └── RoleMiddleware.php        # Proteksi rute 'member' dan 'trainer'
│   └── Models/                           # Eloquent Models (User, MemberProfile, Training, Modul, dll.)
├── database/
│   ├── migrations/                       # Struktur skema tabel MySQL
│   └── seeders/
│       └── DatabaseSeeder.php            # Seeder lengkap (akun, jadwal, modul, riwayat)
├── public/                               # Entry point index.php & symbolic link storage
├── resources/
│   ├── css/
│   │   └── app.css                       # Desain custom, glassmorphism & keyframes animasi
│   ├── js/
│   │   └── app.js                        # Konfigurasi Alpine.js & dependensi Vite
│   └── views/
│       ├── layouts/                      # Layout utama Blade (app.blade.php & guest.blade.php)
│       ├── partials/                     # Header bar navigasi atas, mobile bottom-nav
│       ├── components/                   # Komponen UI (glass-card, stat-card, timeline, dll.)
│       ├── auth/                         # Halaman login & multi-step onboarding
│       ├── member/                       # Tampilan antarmuka Member
│       ├── trainer/                      # Tampilan antarmuka Trainer
│       └── profile/                      # Tampilan antarmuka Profil Akun
├── routes/
│   └── web.php                           # Definisi rute web & grouping role
├── tailwind.config.js                    # Konfigurasi tema warna merah, font, dan keyframes
└── vite.config.js                        # Bundler konfigurasi Vite
```

---

## 🔒 Keamanan & Kesiapan Publikasi GitHub

Proyek ini telah dikonfigurasi secara higienis dan aman untuk dipublikasikan secara publik ke GitHub:
1. **Perlindungan File Sensitif:** File kredensial asli `.env` telah dimasukkan ke dalam `.gitignore` sehingga tidak akan pernah terunggah ke repositori publik.
2. **Template Bersih (`.env.example`):** File `.env.example` bersih dari kunci privat (*no exposed APP_KEY*) maupun kredensial database sensitif.
3. **Penyimpanan Lokal Mandiri (*Self-Generating Files*):** File contoh modul pelatihan (PDF dan PowerPoint) serta berkas pendukung dibuat secara otomatis oleh `DatabaseSeeder.php` saat perintah migrasi dijalankan, sehingga repositori tetap ringan dan bersih tanpa *binary blob* berlebih.
4. **Bebas Kunci API Pihak Ketiga:** Tidak ada token API, rahasia OAuth, atau data pribadi nyata (PII) yang tertanam di dalam kode sumber.
5. **CSRF & Sanitasi Input:** Semua form dilengkapi token proteksi CSRF Laravel dan validasi input yang ketat pada sisi server.

---

## 📄 Lisensi
Proyek ini dilisensikan di bawah [Lisensi MIT](LICENSE). Anda bebas menggunakannya untuk keperluan pembelajaran, pengembangan institusi, maupun portofolio profesional.
