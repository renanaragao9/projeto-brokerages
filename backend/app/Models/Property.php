<?php

namespace App\Models;

use App\Models\Traits\ScopedToUserConstructions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Property extends BaseModel
{
    use ScopedToUserConstructions;

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

    /** Fase física da obra (distinto do `status` comercial). */
    public const CONSTRUCTION_PHASES = [
        'planning',
        'foundation',
        'structure',
        'finishing',
        'completed',
    ];

    protected $fillable = [
        'construction_id',
        'broker_id',
        'program_id',
        'name',
        'slug',
        'type',
        'status',
        'construction_phase',
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

    protected static function booted(): void
    {
        static::addConstructionScope('construction_id');
    }

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

    public function floorPlans(): HasMany
    {
        return $this->hasMany(PropertyFloorPlan::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'property_features')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function banks(): BelongsToMany
    {
        return $this->belongsToMany(Bank::class, 'property_banks')
            ->withTimestamps();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(PropertyBooking::class);
    }

    public function constructionUpdates(): HasMany
    {
        return $this->hasMany(ConstructionUpdate::class);
    }

    public function notices(): MorphMany
    {
        return $this->morphMany(Notice::class, 'noticeable');
    }
}
