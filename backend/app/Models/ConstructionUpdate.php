<?php

namespace App\Models;

use App\Models\Traits\HasFileUploads;
use App\Models\Traits\ScopedToUserConstructions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConstructionUpdate extends BaseModel
{
    use HasFileUploads;
    use ScopedToUserConstructions;

    protected static function booted(): void
    {
        static::addConstructionScope('construction_id', viaRelation: 'property');
    }

    public const STATUSES = [
        'pending',
        'approved',
        'rejected',
    ];

    protected $fillable = [
        'property_id',
        'image',
        'author_name',
        'author_email',
        'author_phone',
        'message',
        'status',
        'rejection_reason',
    ];

    protected function fileUploadDisk(): string
    {
        return 'public';
    }

    protected function fileUploadFields(): array
    {
        return ['image'];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
