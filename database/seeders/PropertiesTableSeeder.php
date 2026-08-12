<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $properties = [];

        foreach ($properties as $name) {
            Property::updateOrCreate(
                ['slug' => $name],
                ['name' => $name],
            );
        }
    }
}
