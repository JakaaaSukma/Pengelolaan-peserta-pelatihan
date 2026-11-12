<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TrainingModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'training_id',
        'judul',
        'deskripsi',
        'kategori',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'downloads_count',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'downloads_count' => 'integer',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        }
        return $bytes . ' B';
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function isPdf(): bool
    {
        return strtolower($this->file_type) === 'pdf';
    }

    public function isPpt(): bool
    {
        return in_array(strtolower($this->file_type), ['ppt', 'pptx']);
    }

    public function getIconAttribute(): string
    {
        return $this->isPdf() ? 'picture_as_pdf' : 'co_present';
    }
}

