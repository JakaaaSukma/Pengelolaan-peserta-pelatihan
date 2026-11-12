<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Member Profiles
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nik', 20)->nullable()->index();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 25)->nullable();
            $table->string('foto')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jurusan')->nullable();
            $table->text('pengalaman_kerja')->nullable();
            $table->text('skill')->nullable();
            $table->text('sertifikat')->nullable();
            $table->string('bidang_minat')->nullable();
            $table->string('lokasi_minat')->nullable();
            $table->string('ekspektasi_gaji')->nullable();
            $table->string('cv_path')->nullable();
            $table->enum('tahap_saat_ini', [
                'pendaftaran',
                'melengkapi_data',
                'pelatihan',
                'evaluasi',
                'interview',
                'penempatan_kerja'
            ])->default('pendaftaran')->index();
            $table->boolean('is_profile_complete')->default(false)->index();
            $table->timestamps();
        });

        // 2. Trainings
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->text('materi');
            $table->enum('tipe', ['offline', 'online'])->default('offline')->index();
            $table->date('tanggal')->index();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('lokasi')->nullable();
            $table->string('link_meeting')->nullable();
            $table->string('platform')->nullable();
            $table->timestamps();
        });

        // 3. Training Attendances
        Schema::create('training_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status_kehadiran', ['hadir', 'izin', 'sakit', 'alpa', 'belum_mulai'])->default('belum_mulai');
            $table->unsignedSmallInteger('nilai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['training_id', 'member_id']);
        });

        // 4. Interviews
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->string('perusahaan');
            $table->string('posisi');
            $table->date('tanggal')->index();
            $table->time('jam');
            $table->enum('tipe', ['offline', 'online'])->default('online');
            $table->string('lokasi')->nullable();
            $table->string('link')->nullable();
            $table->enum('hasil', ['belum_ada', 'lolos', 'tidak_lolos', 'menunggu_hasil'])->default('belum_ada')->index();
            $table->text('feedback')->nullable();
            $table->timestamps();
        });

        // 5. Interview Confirmations
        Schema::create('interview_confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('interviews')->cascadeOnDelete();
            $table->enum('status', ['menunggu', 'hadir', 'tidak_hadir', 'reschedule'])->default('menunggu')->index();
            $table->text('alasan')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });

        // 6. Progress Notes
        Schema::create('progress_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('trainer_id')->constrained('users')->cascadeOnDelete();
            $table->text('catatan');
            $table->timestamps();
        });

        // 7. Placements
        Schema::create('placements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->string('perusahaan');
            $table->string('posisi');
            $table->date('tanggal_mulai')->nullable();
            $table->enum('status', ['proses', 'ditempatkan', 'selesai', 'batal'])->default('proses')->index();
            $table->timestamps();
        });

        // 8. Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->text('pesan');
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('placements');
        Schema::dropIfExists('progress_notes');
        Schema::dropIfExists('interview_confirmations');
        Schema::dropIfExists('interviews');
        Schema::dropIfExists('training_attendances');
        Schema::dropIfExists('trainings');
        Schema::dropIfExists('member_profiles');
    }
};

