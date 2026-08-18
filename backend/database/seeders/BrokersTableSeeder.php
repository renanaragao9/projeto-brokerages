<?php

namespace Database\Seeders;

use App\Models\Broker;
use App\Models\Construction;
use Illuminate\Database\Seeder;

class BrokersTableSeeder extends Seeder
{
    public function run(): void
    {
        $canopusId = Construction::where('name', 'Canopus Construções')->value('id');
        $mateusId = Construction::where('name', 'Mateus Imóveis')->value('id');

        $brokers = [
            [
                'name' => 'Allison Marques',
                'email' => 'alsmarques92@gmail.com',
                'phone' => '85990073696',
                'whatsapp' => '5585990073696',
                'address' => 'Av. Washington Soares',
                'address_number' => '1951',
                'neighborhood' => 'Edson Queiroz',
                'city' => 'Fortaleza',
                'state' => 'CE',
                'zip_code' => '60000-000',
                'construction_id' => $canopusId,
            ],
            [
                'name' => 'Mateus Imóveis',
                'phone' => '8532724806',
                'address' => 'Rua Monsenhor Salazar',
                'address_number' => '883',
                'neighborhood' => 'São João do Tauape',
                'city' => 'Fortaleza',
                'state' => 'CE',
                'zip_code' => '60130-370',
                'construction_id' => $mateusId,
            ],
        ];

        foreach ($brokers as $broker) {
            Broker::updateOrCreate(
                ['name' => $broker['name']],
                [...$broker, 'is_active' => true],
            );
        }
    }
}
