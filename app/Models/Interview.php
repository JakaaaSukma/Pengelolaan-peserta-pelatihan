<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'perusahaan',
        'posisi',
        'tanggal',
        'jam',
        'tipe',
        'lokasi',
        'link',
        'hasil',
        'feedback',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function confirmation(): HasOne
    {
        return $this->hasOne(InterviewConfirmation::class, 'interview_id');
    }

    public function getFullDateTimeAttribute(): string
    {
        return $this->tanggal->format('Y-m-d') . ' ' . $this->jam;
    }
}

