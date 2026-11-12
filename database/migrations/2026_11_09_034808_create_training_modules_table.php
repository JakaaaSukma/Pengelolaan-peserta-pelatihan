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
        Schema::create('training_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('training_id')->nullable()->constrained('trainings')->nullOnDelete();
            $table->string('judul')->index();
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->default('Umum')->index();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type', 10)->index(); // pdf, ppt, pptx
            $table->unsignedBigInteger('file_size')->default(0); // bytes
            $table->unsignedInteger('downloads_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_modules');
    }
};
