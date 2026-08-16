<?php

namespace App\Http\Resources\Api\V1\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'construction_phase' => $this->construction_phase,
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
            'banks' => $this->whenLoaded('banks', fn () => $this->banks->map(fn ($bank) => [
                'id' => $bank->id,
                'name' => $bank->name,
                'logo_url' => $bank->image_path ? Storage::disk('public')->url($bank->image_path) : null,
                'link_simulation' => $bank->link_simulation,
                'description' => $bank->description,
                'instructions' => $bank->instructions,
            ])),
            'floor_plans' => $this->whenLoaded('floorPlans', fn () => $this->floorPlans->map(fn ($floorPlan) => [
                'id' => $floorPlan->id,
                'title' => $floorPlan->title,
                'image_url' => $floorPlan->image_path ? $this->resolveMediaUrl($floorPlan->image_path) : null,
                'tour_url' => $floorPlan->tour_url,
                'sort_order' => $floorPlan->sort_order,
            ])),
            'notices' => $this->whenLoaded('notices', fn () => $this->notices->map(fn ($notice) => [
                'id' => $notice->id,
                'title' => $notice->title,
                'slug' => $notice->slug,
                'excerpt' => $notice->excerpt,
                'image_url' => $notice->image_path ? $this->resolveMediaUrl($notice->image_path) : null,
                'published_at' => $notice->published_at,
            ])),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function resolveMediaUrl(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
