<?php

namespace App\Models;

use App\Models\Traits\HasFileUploads;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bank extends BaseModel
{
    use HasFileUploads;

    protected $fillable = [
        'name',
        'image_path',
        'link_simulation',
        'description',
        'instructions',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
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

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_banks')
            ->withTimestamps();
    }
}
