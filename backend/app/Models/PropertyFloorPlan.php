<?php

namespace App\Models;

use App\Models\Traits\HasFileUploads;
use App\Models\Traits\ScopedToUserConstructions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFloorPlan extends BaseModel
{
    use HasFileUploads;
    use ScopedToUserConstructions;

    protected static function booted(): void
    {
        static::addConstructionScope('construction_id', viaRelation: 'property');
    }

    protected $fillable = [
        'property_id',
        'title',
        'image_path',
        'tour_url',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    protected function fileUploadDisk(): string
    {
        return 'public';
    }

    protected function fileUploadFields(): array
    {
        return ['image_path'];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
