<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            'Swimming Pool',
            'Gym',
            'Playground',
            'Bike Rack',
            'Party Room',
            'Barbecue Area',
            'Elevator',
            '24h Concierge',
            'Pet Place',
            'Coworking',
            'Sports Court',
            'Garden',
        ];

        foreach ($features as $name) {
            Feature::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true],
            );
        }
    }
}
