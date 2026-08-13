<?php

namespace App\Services\Property;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;

class IndexPropertyService
{
    public function run(?string $construction = null): Collection
    {
        return Property::query()
            ->where('is_active', true)
            ->when($construction, fn ($query) => $query->whereHas(
                'construction',
                fn ($constructionQuery) => $constructionQuery->where('name', $construction)
            ))
            ->with(['images' => fn ($query) => $query->orderBy('sort_order')])
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->get();
    }
}
