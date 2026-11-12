<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_pernikahan',
        'alamat',
        'no_hp',
        'foto',
        'pendidikan_terakhir',
        'jurusan',
        'pengalaman_kerja',
        'skill',
        'sertifikat',
        'bidang_minat',
        'lokasi_minat',
        'ekspektasi_gaji',
        'cv_path',
        'tahap_saat_ini',
        'is_profile_complete',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_profile_complete' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function stageList(): array
    {
        return [
            'pendaftaran' => [
                'order' => 1,
                'key' => 'pendaftaran',
                'label' => 'Pendaftaran',
                'icon' => 'how_to_reg',
                'desc' => 'Akun terdaftar dalam sistem',
                'percentage' => 16,
            ],
            'melengkapi_data' => [
                'order' => 2,
                'key' => 'melengkapi_data',
                'label' => 'Melengkapi Data',
                'icon' => 'assignment_turned_in',
                'desc' => 'Pengisian berkas & profil pencari kerja',
                'percentage' => 33,
            ],
            'pelatihan' => [
                'order' => 3,
                'key' => 'pelatihan',
                'label' => 'Pelatihan',
                'icon' => 'school',
                'desc' => 'Mengikuti modul kejuruan dan workshop',
                'percentage' => 50,
            ],
            'evaluasi' => [
                'order' => 4,
                'key' => 'evaluasi',
                'label' => 'Evaluasi',
                'icon' => 'fact_check',
                'desc' => 'Uji kompetensi teknis dan soft-skills',
                'percentage' => 66,
            ],
            'interview' => [
                'order' => 5,
                'key' => 'interview',
                'label' => 'Interview',
                'icon' => 'contact_mail',
                'desc' => 'Wawancara dengan mitra industri/korporat',
                'percentage' => 83,
            ],
            'penempatan_kerja' => [
                'order' => 6,
                'key' => 'penempatan_kerja',
                'label' => 'Penempatan Kerja',
                'icon' => 'work',
                'desc' => 'Telah resmi disalurkan dan bekerja',
                'percentage' => 100,
            ],
        ];
    }

    public function getProgressPercentageAttribute(): int
    {
        $stages = self::stageList();
        return $stages[$this->tahap_saat_ini]['percentage'] ?? 16;
    }

    public function getStageDetailsAttribute(): array
    {
        $all = self::stageList();
        $currentOrder = $all[$this->tahap_saat_ini]['order'] ?? 1;

        $result = [];
        foreach ($all as $key => $stage) {
            if ($stage['order'] < $currentOrder) {
                $status = 'selesai';
            } elseif ($stage['order'] === $currentOrder) {
                $status = 'berjalan';
            } else {
                $status = 'belum_mulai';
            }

            $result[] = array_merge($stage, [
                'status' => $status,
                'is_current' => ($stage['order'] === $currentOrder),
            ]);
        }

        return $result;
    }
}

