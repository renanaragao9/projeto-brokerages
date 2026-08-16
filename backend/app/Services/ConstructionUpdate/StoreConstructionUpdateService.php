<?php

namespace App\Services\ConstructionUpdate;

use App\Models\ConstructionUpdate;
use Illuminate\Http\UploadedFile;

class StoreConstructionUpdateService
{
    public function run(array $data, UploadedFile $image): ConstructionUpdate
    {
        $path = $image->store('construction-updates/'.$data['property_id'], 'public');

        return ConstructionUpdate::create([
            ...$data,
            'image' => $path,
            'status' => 'pending',
        ]);
    }
}
