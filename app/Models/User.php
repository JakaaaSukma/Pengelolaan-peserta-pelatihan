<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function isTrainer(): bool
    {
        return $this->role === 'trainer';
    }

    public function profile(): HasOne
    {
        return $this->hasOne(MemberProfile::class, 'user_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(TrainingAttendance::class, 'member_id');
    }

    public function trainingsAsTrainer(): HasMany
    {
        return $this->hasMany(Training::class, 'trainer_id');
    }

    public function uploadedModules(): HasMany
    {
        return $this->hasMany(TrainingModule::class, 'trainer_id');
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class, 'member_id');
    }

    public function progressNotesAsMember(): HasMany
    {
        return $this->hasMany(ProgressNote::class, 'member_id');
    }

    public function progressNotesAsTrainer(): HasMany
    {
        return $this->hasMany(ProgressNote::class, 'trainer_id');
    }

    public function placements(): HasMany
    {
        return $this->hasMany(Placement::class, 'member_id');
    }

    public function latestPlacement(): HasOne
    {
        return $this->hasOne(Placement::class, 'member_id')->latestOfMany();
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id')->where('is_read', false);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->profile && $this->profile->foto) {
            return asset('storage/' . $this->profile->foto);
        }
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=120";
    }
}
