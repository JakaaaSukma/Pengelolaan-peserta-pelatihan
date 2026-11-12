<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'judul',
        'materi',
        'tipe',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'link_meeting',
        'platform',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(TrainingAttendance::class, 'training_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(TrainingModule::class, 'training_id');
    }

    public function isOffline(): bool
    {
        return $this->tipe === 'offline';
    }

    public function isOnline(): bool
    {
        return $this->tipe === 'online';
    }
}

