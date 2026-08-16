<?php

namespace App\Http\Resources\Api\V1\ConstructionUpdate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ConstructionUpdateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image_url' => Storage::disk('public')->url($this->image),
            'author_name' => $this->author_name,
            'message' => $this->message,
            'created_at' => $this->created_at,
        ];
    }
}
