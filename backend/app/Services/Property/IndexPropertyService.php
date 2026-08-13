<?php

namespace App\Services\Property;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;

class IndexPropertyService
{
    public function run(): Collection
    {
        return Property::query()
            ->where('is_active', true)
            ->with(['images' => fn ($query) => $query->orderBy('sort_order')])
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->get();
    }
}
