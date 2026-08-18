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
            [
                'name' => 'Mateus Imóveis',
                'website_url' => null,
                'description' => 'Imobiliária',
            ],
        ];

        foreach ($constructions as $construction) {
            Construction::updateOrCreate(
                ['name' => $construction['name']],
                [
                    'website_url' => $construction['website_url'] ?? null,
                    'description' => $construction['description'] ?? null,
                    'is_active' => true,
                ],
            );
        }
    }
}
