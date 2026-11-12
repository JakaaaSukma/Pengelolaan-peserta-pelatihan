<?php

namespace Database\Seeders;

use App\Models\Interview;
use App\Models\InterviewConfirmation;
use App\Models\MemberProfile;
use App\Models\Notification;
use App\Models\Placement;
use App\Models\ProgressNote;
use App\Models\Training;
use App\Models\TrainingAttendance;
use App\Models\TrainingModule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Akun Demo Trainer Utama
        $trainer = User::create([
            'name' => 'Bambang Sudarsono, M.Kom',
            'email' => 'trainer@demo.com',
            'password' => $password,
            'role' => 'trainer',
        ]);

        $trainer2 = User::create([
            'name' => 'Siti Rahmawati, S.T.',
            'email' => 'siti.trainer@demo.com',
            'password' => $password,
            'role' => 'trainer',
        ]);

        // 2. Akun Demo Member Utama
        $demoMember = User::create([
            'name' => 'Arya Pratama',
            'email' => 'member@demo.com',
            'password' => $password,
            'role' => 'member',
        ]);

        MemberProfile::create([
            'user_id' => $demoMember->id,
            'nik' => '3273012304980002',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1999-04-12',
            'jenis_kelamin' => 'L',
            'status_pernikahan' => 'Belum Menikah',
            'alamat' => 'Jl. Dago Asri No. 45, Coblong, Kota Bandung, Jawa Barat',
            'no_hp' => '081234567890',
            'pendidikan_terakhir' => 'S1 Teknik Informatika',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'pengalaman_kerja' => 'Magang Junior Frontend Dev di Digital Kreatif Studio (6 bulan), Freelance Web Design (1 tahun)',
            'skill' => 'Laravel, Tailwind CSS, Alpine.js, Vue.js, MySQL, REST API, UI/UX Design, Figma',
            'sertifikat' => 'BNSP Junior Web Developer (2023), Dicoding Menjadi Front-End Web Developer Expert',
            'bidang_minat' => 'Full-Stack Web Developer & UI Engineer',
            'lokasi_minat' => 'Jakarta / Bandung / Remote (WFA)',
            'ekspektasi_gaji' => 'Rp 7.500.000 - Rp 10.000.000',
            'tahap_saat_ini' => 'interview',
            'is_profile_complete' => true,
        ]);

        // 3. Tambahan Member Realistis (12 Peserta dengan Tahapan Berbeda)
        $memberCandidates = [
            [
                'name' => 'Dewi Lestari Anggraeni',
                'email' => 'dewi.lestari@gmail.com',
                'tahap' => 'penempatan_kerja',
                'jurusan' => 'Sistem Informasi',
                'pendidikan' => 'S1',
                'perusahaan' => 'PT Astra International Tbk',
                'posisi' => 'IT Business Analyst',
                'status_placed' => 'ditempatkan',
                'gender' => 'P'
            ],
            [
                'name' => 'Rian Hidayat',
                'email' => 'rian.hidayat@gmail.com',
                'tahap' => 'penempatan_kerja',
                'jurusan' => 'Teknik Komputer',
                'pendidikan' => 'D3',
                'perusahaan' => 'PT Bank Mandiri (Persero) Tbk',
                'posisi' => 'Junior Cloud Administrator',
                'status_placed' => 'ditempatkan',
                'gender' => 'L'
            ],
            [
                'name' => 'Nabila Putri Cahyani',
                'email' => 'nabila.putri@gmail.com',
                'tahap' => 'interview',
                'jurusan' => 'Desain Komunikasi Visual',
                'pendidikan' => 'S1',
                'perusahaan' => 'PT Telkom Indonesia',
                'posisi' => 'Product UI/UX Designer',
                'status_placed' => 'proses',
                'gender' => 'P'
            ],
            [
                'name' => 'Muhammad Fajar Nugraha',
                'email' => 'fajar.nugraha@gmail.com',
                'tahap' => 'interview',
                'jurusan' => 'Teknik Informatika',
                'pendidikan' => 'S1',
                'perusahaan' => 'Tokopedia by ByteDance',
                'posisi' => 'Backend Engineer (Go/PHP)',
                'status_placed' => 'proses',
                'gender' => 'L'
            ],
            [
                'name' => 'Anisa Rahmawati',
                'email' => 'anisa.rahma@gmail.com',
                'tahap' => 'evaluasi',
                'jurusan' => 'Manajemen Informatika',
                'pendidikan' => 'D3',
                'perusahaan' => null,
                'posisi' => null,
                'status_placed' => 'proses',
                'gender' => 'P'
            ],
            [
                'name' => 'Dimas Bagus Wicaksono',
                'email' => 'dimas.wicaksono@gmail.com',
                'tahap' => 'evaluasi',
                'jurusan' => 'Teknik Elektro',
                'pendidikan' => 'S1',
                'perusahaan' => null,
                'posisi' => null,
                'status_placed' => 'proses',
                'gender' => 'L'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@gmail.com',
                'tahap' => 'pelatihan',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'pendidikan' => 'SMK',
                'perusahaan' => null,
                'posisi' => null,
                'status_placed' => 'proses',
                'gender' => 'P'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'tahap' => 'pelatihan',
                'jurusan' => 'Teknik Komputer Jaringan',
                'pendidikan' => 'SMK',
                'perusahaan' => null,
                'posisi' => null,
                'status_placed' => 'proses',
                'gender' => 'L'
            ],
            [
                'name' => 'Gita Gutawa Putri',
                'email' => 'gita.putri@gmail.com',
                'tahap' => 'pelatihan',
                'jurusan' => 'Ilmu Komputer',
                'pendidikan' => 'S1',
                'perusahaan' => null,
                'posisi' => null,
                'status_placed' => 'proses',
                'gender' => 'P'
            ],
            [
                'name' => 'Bayu Segara',
                'email' => 'bayu.segara@gmail.com',
                'tahap' => 'melengkapi_data',
                'jurusan' => 'Teknik Telekomunikasi',
                'pendidikan' => 'D3',
                'perusahaan' => null,
                'posisi' => null,
                'status_placed' => 'proses',
                'gender' => 'L'
            ],
            [
                'name' => 'Clara Claudia',
                'email' => 'clara.claudia@gmail.com',
                'tahap' => 'pendaftaran',
                'jurusan' => 'Administrasi Bisnis',
                'pendidikan' => 'S1',
                'perusahaan' => null,
                'posisi' => null,
                'status_placed' => 'proses',
                'gender' => 'P'
            ],
            [
                'name' => 'Faisal Reza',
                'email' => 'faisal.reza@gmail.com',
                'tahap' => 'pendaftaran',
                'jurusan' => 'Sains Komputasi',
                'pendidikan' => 'S1',
                'perusahaan' => null,
                'posisi' => null,
                'status_placed' => 'proses',
                'gender' => 'L'
            ],
        ];

        $allMembers = [$demoMember];

        foreach ($memberCandidates as $idx => $m) {
            $user = User::create([
                'name' => $m['name'],
                'email' => $m['email'],
                'password' => $password,
                'role' => 'member',
            ]);

            $isComplete = in_array($m['tahap'], ['pelatihan', 'evaluasi', 'interview', 'penempatan_kerja']);

            MemberProfile::create([
                'user_id' => $user->id,
                'nik' => '3273' . rand(100000000000, 999999999999),
                'tempat_lahir' => ($m['gender'] === 'L' ? 'Surabaya' : 'Yogyakarta'),
                'tanggal_lahir' => '2000-0' . rand(1, 9) . '-1' . rand(0, 9),
                'jenis_kelamin' => $m['gender'],
                'status_pernikahan' => 'Belum Menikah',
                'alamat' => 'Jl. Merdeka No. ' . (10 + $idx) . ', Kota Bandung',
                'no_hp' => '0812' . rand(10000000, 99999999),
                'pendidikan_terakhir' => $m['pendidikan'] . ' ' . $m['jurusan'],
                'jurusan' => $m['jurusan'],
                'pengalaman_kerja' => $isComplete ? 'Magang Kerja Vokasi 6 Bulan di Mitra Industri' : null,
                'skill' => 'HTML, CSS, JavaScript, Laravel, Git, Problem Solving',
                'sertifikat' => $isComplete ? 'Sertifikat Kompetensi BNSP' : null,
                'bidang_minat' => 'Teknologi Informasi & Rekayasa Perangkat Lunak',
                'lokasi_minat' => 'Jabodetabek & Bandung',
                'ekspektasi_gaji' => 'Rp 6.000.000 - Rp 8.500.000',
                'tahap_saat_ini' => $m['tahap'],
                'is_profile_complete' => $isComplete,
            ]);

            if ($m['perusahaan']) {
                Placement::create([
                    'member_id' => $user->id,
                    'perusahaan' => $m['perusahaan'],
                    'posisi' => $m['posisi'],
                    'tanggal_mulai' => $m['tahap'] === 'penempatan_kerja' ? Carbon::now()->subMonths(1) : Carbon::now()->addDays(14),
                    'status' => $m['status_placed'],
                ]);
            }

            $allMembers[] = $user;
        }

        // 4. Jadwal Pelatihan (Trainings)
        $trainings = [
            [
                'trainer_id' => $trainer->id,
                'judul' => 'Full-Stack Modern: Laravel 10 & Tailwind UI Architecture',
                'materi' => 'Mendalami arsitektur MVC, Eloquent ORM optimal, Tailwind CSS Glassmorphism, dan implementasi reactive komponen via Alpine.js.',
                'tipe' => 'offline',
                'tanggal' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'lokasi' => 'Lab Komputer 3 - Gedung Pelatihan Vokasi lt. 2, Bandung',
                'link_meeting' => null,
                'platform' => null,
            ],
            [
                'trainer_id' => $trainer->id,
                'judul' => 'RESTful API Engineering & Secure Token Authentication',
                'materi' => 'Konstruksi API enterprise, middleware proteksi Sanctum, CORS handling, dan dokumentasi Postman/Swagger.',
                'tipe' => 'online',
                'tanggal' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '16:00:00',
                'lokasi' => null,
                'link_meeting' => 'https://meet.google.com/xyz-workforce-train',
                'platform' => 'Google Meet',
            ],
            [
                'trainer_id' => $trainer2->id,
                'judul' => 'Mastering Interview Teknis & Portofolio Showcase',
                'materi' => 'Simulasi live coding challenge, penyusunan studi kasus portofolio GitHub, serta teknik negosiasi offering letter.',
                'tipe' => 'online',
                'tanggal' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:30:00',
                'lokasi' => null,
                'link_meeting' => 'https://zoom.us/j/9876543210',
                'platform' => 'Zoom Workplace',
            ],
            [
                'trainer_id' => $trainer->id,
                'judul' => 'Work Ready: Git Workflow, CI/CD Pipeline & Deploy ke Cloud',
                'materi' => 'Alur kerja GitHub branching strategy, automated testing pre-merge, Docker containerization, dan deployment ke cloud VPS.',
                'tipe' => 'offline',
                'tanggal' => Carbon::now()->addDays(6)->format('Y-m-d'),
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '16:00:00',
                'lokasi' => 'Auditorium Smart Talent, Gedung Pusat Inovasi lt. 4',
                'link_meeting' => null,
                'platform' => null,
            ],
        ];

        $trainingModels = [];
        foreach ($trainings as $t) {
            $tModel = Training::create($t);
            $trainingModels[] = $tModel;

            // Generate Attendances untuk setiap member yang sudah di tahap pelatihan ke atas
            foreach ($allMembers as $mem) {
                if (in_array($mem->profile->tahap_saat_ini, ['pelatihan', 'evaluasi', 'interview', 'penempatan_kerja'])) {
                    $isPast = Carbon::parse($t['tanggal'])->isPast();
                    TrainingAttendance::create([
                        'training_id' => $tModel->id,
                        'member_id' => $mem->id,
                        'status_kehadiran' => $isPast ? (rand(1, 10) > 2 ? 'hadir' : 'izin') : 'belum_mulai',
                        'nilai' => $isPast ? rand(82, 98) : null,
                        'catatan' => $isPast ? 'Aktif dalam sesi praktik studi kasus dan diskusi kelompok.' : null,
                    ]);
                }
            }
        }

        // 5. Jadwal Interview & Konfirmasi
        $interviews = [
            [
                'member_id' => $demoMember->id,
                'perusahaan' => 'PT Bank Central Asia Tbk (BCA)',
                'posisi' => 'Junior Web Application Engineer',
                'tanggal' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'jam' => '10:00:00',
                'tipe' => 'online',
                'lokasi' => null,
                'link' => 'https://meet.google.com/bca-talent-interview',
                'hasil' => 'menunggu_hasil',
                'feedback' => null,
                'conf_status' => 'menunggu',
            ],
            [
                'member_id' => $demoMember->id,
                'perusahaan' => 'PT Telkom Indonesia (Persero) Tbk',
                'posisi' => 'Frontend UI Engineer (Digital Talent Pipeline)',
                'tanggal' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'jam' => '13:30:00',
                'tipe' => 'offline',
                'lokasi' => 'Telkom Landmark Tower lt. 18, Jl. Jend. Gatot Subroto Kav. 52, Jakarta Selatan',
                'link' => null,
                'hasil' => 'menunggu_hasil',
                'feedback' => null,
                'conf_status' => 'hadir',
            ],
            [
                'member_id' => $demoMember->id,
                'perusahaan' => 'PT Tokopedia (GoTo Group)',
                'posisi' => 'Associate Software Engineer',
                'tanggal' => Carbon::now()->subDays(7)->format('Y-m-d'),
                'jam' => '14:00:00',
                'tipe' => 'online',
                'lokasi' => null,
                'link' => 'https://zoom.us/j/tokopedia-interview',
                'hasil' => 'lolos',
                'feedback' => 'Kemampuan logika algoritma sangat baik, memahami component architecture dengan Tailwind dan reactive state.',
                'conf_status' => 'hadir',
            ],
            [
                'member_id' => $allMembers[3]->id, // Nabila
                'perusahaan' => 'Shopee Indonesia',
                'posisi' => 'UI/UX Visual Specialist',
                'tanggal' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'jam' => '11:00:00',
                'tipe' => 'online',
                'lokasi' => null,
                'link' => 'https://meet.google.com/shopee-interview',
                'hasil' => 'menunggu_hasil',
                'feedback' => null,
                'conf_status' => 'hadir',
            ],
            [
                'member_id' => $allMembers[4]->id, // Fajar
                'perusahaan' => 'PT DCI Indonesia Tbk',
                'posisi' => 'Junior DevOps Specialist',
                'tanggal' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'jam' => '09:30:00',
                'tipe' => 'offline',
                'lokasi' => 'DCI Data Center Park, Cibitung, Bekasi',
                'link' => null,
                'hasil' => 'menunggu_hasil',
                'feedback' => null,
                'conf_status' => 'menunggu',
            ],
        ];

        foreach ($interviews as $inv) {
            $confStatus = $inv['conf_status'];
            unset($inv['conf_status']);

            $interview = Interview::create($inv);

            InterviewConfirmation::create([
                'interview_id' => $interview->id,
                'status' => $confStatus,
                'alasan' => $confStatus === 'tidak_hadir' ? 'Ada keperluan mendesak keluarga.' : null,
                'confirmed_at' => $confStatus !== 'menunggu' ? Carbon::now()->subHours(rand(1, 24)) : null,
            ]);
        }

        // 6. Catatan Perkembangan (Progress Notes dari Trainer)
        ProgressNote::create([
            'member_id' => $demoMember->id,
            'trainer_id' => $trainer->id,
            'catatan' => 'Arya menunjukkan progres signifikan dalam pemahaman Tailwind & Blade component architecture. Nilai evaluasi teknis 94/100. Disarankan memperdalam konsep micro-interactions sebelum jadwal interview dengan BCA.',
        ]);

        ProgressNote::create([
            'member_id' => $demoMember->id,
            'trainer_id' => $trainer2->id,
            'catatan' => 'Simulasi interview menunjukkan kepercayaan diri yang solid dan komunikasi teknis yang terstruktur. Siap dikirim ke mitra industri.',
        ]);

        // 7. Notifikasi
        Notification::create([
            'user_id' => $demoMember->id,
            'judul' => 'Jadwal Interview Baru Masuk',
            'pesan' => 'Anda dijadwalkan wawancara kerja dengan PT Bank Central Asia Tbk untuk posisi Junior Web Application Engineer. Segera lakukan konfirmasi kehadiran.',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $demoMember->id,
            'judul' => 'Nilai Pelatihan Dirilis',
            'pesan' => 'Trainer telah memberikan nilai 92 untuk modul Full-Stack Modern: Laravel & Tailwind Architecture.',
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $trainer->id,
            'judul' => 'Konfirmasi Kehadiran Interview',
            'pesan' => 'Arya Pratama telah mengonfirmasi [HADIR] untuk sesi interview PT Telkom Indonesia.',
            'is_read' => false,
        ]);

        // 8. Modul Pelatihan (PPT & PDF)
        $dir = storage_path('app/public/training_modules');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $samplePdf = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000010 00000 n\n0000000053 00000 n\n0000000102 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n185\n%%EOF\n";
        if (!file_exists($dir . '/modul-web-development.pdf')) {
            file_put_contents($dir . '/modul-web-development.pdf', $samplePdf);
        }
        if (!file_exists($dir . '/modul-uiux-design-system.pdf')) {
            file_put_contents($dir . '/modul-uiux-design-system.pdf', $samplePdf);
        }
        if (!file_exists($dir . '/presentasi-interview-mastery.pptx')) {
            file_put_contents($dir . '/presentasi-interview-mastery.pptx', "PK\x03\x04Demo PowerPoint Presentation Content for TalentTrack Vocational Training");
        }
        if (!file_exists($dir . '/presentasi-agile-scrum.ppt')) {
            file_put_contents($dir . '/presentasi-agile-scrum.ppt', "D0CF11E0Demo PowerPoint Presentation Content for Agile Scrum");
        }

        $tFirst = Training::first();
        TrainingModule::create([
            'trainer_id' => $trainer->id,
            'training_id' => $tFirst ? $tFirst->id : null,
            'judul' => 'Modul Arsitektur Modern Full-Stack Web & REST API',
            'deskripsi' => 'Panduan komprehensif struktur MVC, clean code, Eloquent relationships, dan keamanan API RESTful siap industri.',
            'kategori' => 'Web Development',
            'file_path' => 'training_modules/modul-web-development.pdf',
            'file_name' => 'Modul-FullStack-Web-Dev-Vokasi.pdf',
            'file_type' => 'pdf',
            'file_size' => 2516582,
            'downloads_count' => 24,
        ]);

        TrainingModule::create([
            'trainer_id' => $trainer->id,
            'training_id' => null,
            'judul' => 'Presentasi Sukses Lolos HR & Technical Coding Interview',
            'deskripsi' => 'Slide materi persiapan mental, format jawaban metode STAR, bedah studi kasus teknis, dan negosiasi penawaran kerja.',
            'kategori' => 'Persiapan Karir',
            'file_path' => 'training_modules/presentasi-interview-mastery.pptx',
            'file_name' => 'Slide-Mastery-HR-Technical-Interview.pptx',
            'file_type' => 'pptx',
            'file_size' => 5347737,
            'downloads_count' => 41,
        ]);

        TrainingModule::create([
            'trainer_id' => $trainer2->id,
            'training_id' => null,
            'judul' => 'Design System, Wireframing & Interactive Prototyping',
            'deskripsi' => 'Buku panduan UI/UX standar industri, perancangan token warna, tipografi, dan auto-layout komponen di Figma.',
            'kategori' => 'UI/UX Design',
            'file_path' => 'training_modules/modul-uiux-design-system.pdf',
            'file_name' => 'Modul-UIUX-Design-System-Figma.pdf',
            'file_type' => 'pdf',
            'file_size' => 3984588,
            'downloads_count' => 18,
        ]);

        TrainingModule::create([
            'trainer_id' => $trainer->id,
            'training_id' => null,
            'judul' => 'Slide Presentasi Metodologi Agile Scrum & Git Workflow',
            'deskripsi' => 'Materi pengenalan siklus sprint, backlog grooming, daily standup, dan kolaborasi branching Git tim engineering.',
            'kategori' => 'Manajemen Proyek',
            'file_path' => 'training_modules/presentasi-agile-scrum.ppt',
            'file_name' => 'Slide-Agile-Scrum-Git-Workflow.ppt',
            'file_type' => 'ppt',
            'file_size' => 4404019,
            'downloads_count' => 15,
        ]);
    }
}
