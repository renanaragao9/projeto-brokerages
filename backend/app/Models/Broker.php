<?php

namespace App\Models;

use App\Models\Traits\ScopedToUserConstructions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Broker extends BaseModel
{
    use ScopedToUserConstructions;

    protected static function booted(): void
    {
        static::addConstructionScope('construction_id');
    }

    protected $fillable = [
        'construction_id',
        'name',
        'email',
        'phone',
        'whatsapp',
        'website_url',
        'company_name',
        'creci',
        'description',
        'address',
        'address_number',
        'address_complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_active' => 'boolean',
        ];
    }

    public function construction(): BelongsTo
    {
        return $this->belongsTo(Construction::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function propertyBookings(): HasMany
    {
        return $this->hasMany(PropertyBooking::class);
    }

    public function notices(): MorphMany
    {
        return $this->morphMany(Notice::class, 'noticeable');
    }
}
