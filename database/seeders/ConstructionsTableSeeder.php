<?php

namespace Database\Seeders;

use App\Models\Construction;
use Illuminate\Database\Seeder;

class ConstructionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $constructions = [];

        foreach ($constructions as $name) {
            Construction::updateOrCreate(
                ['name' => $name],
                ['is_active' => true],
            );
        }
    }
}
