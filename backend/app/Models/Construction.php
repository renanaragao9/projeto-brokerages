<?php

namespace App\Models;

use App\Models\Traits\ScopedToUserConstructions;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Construction extends BaseModel
{
    use ScopedToUserConstructions;

    protected static function booted(): void
    {
        static::addConstructionScope('constructions.id');
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website_url',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function brokers(): HasMany
    {
        return $this->hasMany(Broker::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function notices(): MorphMany
    {
        return $this->morphMany(Notice::class, 'noticeable');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
