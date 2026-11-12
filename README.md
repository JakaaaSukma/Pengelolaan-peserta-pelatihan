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

[Fitur Utama](#-fitur-utama) • [Desain & Performa](#-desain--performa) • [Struktur Direktori](#-struktur-direktori-utama) • 
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


---

## 📄 Lisensi
Proyek ini dilisensikan di bawah [Lisensi MIT](LICENSE). Anda bebas menggunakannya untuk keperluan pembelajaran, pengembangan institusi, maupun portofolio profesional.
