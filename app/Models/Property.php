<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends BaseModel
{
    public const TYPES = [
        'apartment',
        'house',
        'condominium',
        'commercial',
        'land',
        'development',
    ];

    public const STATUSES = [
        'available',
        'reserved',
        'sold',
        'rented',
        'unavailable',
    ];

    protected $fillable = [
        'construction_id',
        'broker_id',
        'program_id',
        'name',
        'slug',
        'type',
        'status',
        'description',
        'price',
        'condominium_fee',
        'iptu',
        'area',
        'total_area',
        'bedrooms',
        'suites',
        'bathrooms',
        'parking_spaces',
        'address',
        'address_number',
        'address_complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'condominium_fee' => 'decimal:2',
            'iptu' => 'decimal:2',
            'area' => 'decimal:2',
            'total_area' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function construction(): BelongsTo
    {
        return $this->belongsTo(Construction::class);
    }

    public function broker(): BelongsTo
    {
        return $this->belongsTo(Broker::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'property_features')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(PropertyBooking::class);
    }
}
