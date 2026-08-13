<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Construction extends BaseModel
{
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
}
