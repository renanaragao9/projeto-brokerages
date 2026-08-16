<?php

namespace App\Models;

use App\Models\Traits\HasFileUploads;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, HasFileUploads, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image_path',
        'status',
        'role_id',
        'is_super_admin',
        'last_login_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function constructions(): BelongsToMany
    {
        return $this->belongsToMany(Construction::class)->withTimestamps();
    }

    protected function fileUploadFields(): array
    {
        return ['image_path'];
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isActive();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        if (! Storage::disk($this->fileUploadDisk())->exists($this->image_path)) {
            return null;
        }

        return route('avatars.serve', ['user' => $this->getKey()]);
    }
}
