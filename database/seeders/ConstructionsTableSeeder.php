<?php

namespace Database\Seeders;

use App\Models\Construction;
use Illuminate\Database\Seeder;

class ConstructionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $constructions = [
            [
                'name' => 'Canopus Construções',
                'website_url' => 'https://canopusconstrucoes.com.br',
            ],
        ];

        foreach ($constructions as $construction) {
            Construction::updateOrCreate(
                ['name' => $construction['name']],
                ['website_url' => $construction['website_url'], 'is_active' => true],
            );
        }
    }
}
