<?php

namespace App\Models;

use App\Models\Traits\HasFileUploads;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends BaseModel
{
    use HasFileUploads;

    protected $fillable = [
        'property_id',
        'path',
        'alt',
        'title',
        'sort_order',
        'is_cover',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_cover' => 'boolean',
        ];
    }

    protected function fileUploadDisk(): string
    {
        return 'public';
    }

    protected function fileUploadFields(): array
    {
        return ['path'];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
