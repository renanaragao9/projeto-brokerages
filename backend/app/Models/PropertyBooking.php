<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyBooking extends BaseModel
{
    public const STATUSES = [
        'pending',
        'confirmed',
        'cancelled',
        'completed',
    ];

    protected $fillable = [
        'property_id',
        'broker_id',
        'name',
        'email',
        'phone',
        'message',
        'scheduled_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function broker(): BelongsTo
    {
        return $this->belongsTo(Broker::class);
    }
}
