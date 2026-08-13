<?php

namespace App\Http\Resources\Api\V1\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'status' => $this->status,
            'description' => $this->description,
            'price' => $this->price,
            'condominium_fee' => $this->condominium_fee,
            'iptu' => $this->iptu,
            'area' => $this->area,
            'total_area' => $this->total_area,
            'bedrooms' => $this->bedrooms,
            'suites' => $this->suites,
            'bathrooms' => $this->bathrooms,
            'parking_spaces' => $this->parking_spaces,
            'address' => $this->address,
            'address_number' => $this->address_number,
            'address_complement' => $this->address_complement,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'is_featured' => $this->is_featured,
            'construction' => $this->whenLoaded('construction', fn () => [
                'id' => $this->construction->id,
                'name' => $this->construction->name,
            ]),
            'images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($image) => [
                'id' => $image->id,
                'url' => $image->path,
                'alt' => $image->alt,
                'title' => $image->title,
                'sort_order' => $image->sort_order,
                'is_cover' => $image->is_cover,
            ])),
            'features' => $this->whenLoaded('features', fn () => $this->features->map(fn ($feature) => [
                'id' => $feature->id,
                'name' => $feature->name,
                'slug' => $feature->slug,
                'icon' => $feature->icon,
                'value' => $feature->pivot->value ?? null,
            ])),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
