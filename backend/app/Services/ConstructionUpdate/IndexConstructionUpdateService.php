<?php

namespace App\Services\ConstructionUpdate;

use App\Models\ConstructionUpdate;
use Illuminate\Database\Eloquent\Collection;

class IndexConstructionUpdateService
{
    public function run(int|string $propertyId): Collection
    {
        return ConstructionUpdate::query()
            ->where('property_id', $propertyId)
            ->where('status', 'approved')
            ->latest()
            ->get();
    }
}
