<?php

namespace App\Services\Property;

use App\Models\Property;

class ShowPropertyService
{
    public function run(Property $property): Property
    {
        return $property->load([
            'construction',
            'features',
            'banks' => fn ($query) => $query->where('is_active', true),
            'images' => fn ($query) => $query->orderBy('sort_order'),
            'floorPlans' => fn ($query) => $query->orderBy('sort_order'),
            'notices' => fn ($query) => $query
                ->where('is_published', true)
                ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))
                ->latest('published_at'),
        ]);
    }
}
