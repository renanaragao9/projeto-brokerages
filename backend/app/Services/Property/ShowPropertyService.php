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
            'images' => fn ($query) => $query->orderBy('sort_order'),
        ]);
    }
}
