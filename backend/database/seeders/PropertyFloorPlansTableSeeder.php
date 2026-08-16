<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyFloorPlan;
use Illuminate\Database\Seeder;

class PropertyFloorPlansTableSeeder extends Seeder
{
    public function run(): void
    {
        $property = Property::where('name', 'Gran Village do Sol II')->first();

        if (! $property) {
            return;
        }

        $floorPlans = [
            [
                'title' => 'Planta 2 quartos',
                'image_path' => 'https://canopusconstrucoes.com.br/storage/imagens/midias/RDxIGZvvTqbEvXGab0UTFraZYDoPLn20251030105251.jpg',
                'tour_url' => null,
                'sort_order' => 0,
            ],
            [
                /** TODO: trocar por um tour 3D real do imóvel antes de publicar — este é só um exemplo público (Kuula) pra provar que o embed funciona. */
                'title' => 'Tour virtual 360° (exemplo)',
                'image_path' => null,
                'tour_url' => 'https://kuula.co/share/h9v9M?logo=1&info=1&fs=1&vr=0&sd=1&thumbs=1',
                'sort_order' => 1,
            ],
        ];

        foreach ($floorPlans as $floorPlan) {
            PropertyFloorPlan::updateOrCreate(
                ['property_id' => $property->id, 'title' => $floorPlan['title']],
                [
                    'image_path' => $floorPlan['image_path'],
                    'tour_url' => $floorPlan['tour_url'],
                    'sort_order' => $floorPlan['sort_order'],
                ],
            );
        }
    }
}
