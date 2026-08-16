<?php

namespace App\Models;

use App\Models\Traits\HasFileUploads;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notice extends BaseModel
{
    use HasFileUploads;

    public const NOTICEABLE_TYPES = [
        Construction::class => 'Construtora',
        Broker::class => 'Corretor',
        Property::class => 'Imóvel',
        Bank::class => 'Banco',
    ];

    public const NOTICEABLE_TYPES_ALIASES = [
        'construction' => Construction::class,
        'broker' => Broker::class,
        'property' => Property::class,
        'bank' => Bank::class,
    ];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image_path',
        'media_url',
        'is_published',
        'published_at',
        'noticeable_id',
        'noticeable_type',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
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

    public function noticeable(): MorphTo
    {
        return $this->morphTo();
    }
}
