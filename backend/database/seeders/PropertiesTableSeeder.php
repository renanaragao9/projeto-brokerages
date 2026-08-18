<?php

namespace Database\Seeders;

use App\Models\Broker;
use App\Models\Construction;
use App\Models\Feature;
use App\Models\Program;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $defaultBrokerId = Broker::where('name', 'Allison Marques')->value('id');

        $properties = [
            [
                'name' => 'Casa Duplex na Aldeota',
                'type' => 'house',
                'status' => 'available',
                'construction_phase' => 'completed',
                'description' => 'Casa duplex ampla e reformada na Aldeota, a poucos minutos da praia e dos principais pontos de comércio e lazer da cidade. Living integrado, cozinha planejada e quintal privativo com churrasqueira — tudo isso sem taxa de condomínio e com total privacidade. Ideal para quem busca morar bem, com conforto e localização estratégica.',
                'address' => 'Rua Barão de Aracati',
                'address_number' => '1230',
                'neighborhood' => 'Aldeota',
                'city' => 'Fortaleza',
                'state' => 'CE',
                'price' => 3500.00,
                'condominium_fee' => null,
                'iptu' => 150.00,
                'total_area' => 220.00,
                'area' => 180.00,
                'bedrooms' => 3,
                'suites' => 1,
                'bathrooms' => 3,
                'parking_spaces' => 2,
                'construction' => 'Mateus Imóveis',
                'broker' => 'Mateus Imóveis',
                'program' => null,
                'is_featured' => true,
                'features' => ['Garden', 'Barbecue Area', 'Pet Place'],
                'images' => [
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1600&q=80',
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1600&q=80',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1600&q=80',
                    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=1600&q=80',
                ],
            ],
            [
                'name' => 'Gran Village do Sol II',
                'type' => 'condominium',
                'status' => 'available',
                'construction_phase' => 'completed',
                'description' => 'O futuro que você merece está prestes a se tornar realidade em Fortaleza.',
                'address' => 'Avenida Recreio',
                'address_number' => '1590',
                'neighborhood' => 'Lagoa Redonda',
                'city' => 'Fortaleza',
                'state' => 'CE',
                'total_area' => 14420.26,
                'area' => 46.52,
                'bedrooms' => 2,
                'suites' => 1,
                'bathrooms' => 0,
                'parking_spaces' => 0,
                'construction' => 'Canopus Construções',
                'program' => 'Minha Casa Minha Vida',
                'features' => ['Swimming Pool', 'Playground', 'Sports Court', 'Game Table', 'Bike Rack'],
                'images' => [
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/RDxIGZvvTqbEvXGab0UTFraZYDoPLn20251030105251.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/GOfjpImwMROpgW1ftEzdhfitaXrBZl20251030105251.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/1LZlh7tuzgN8p0DUABSVOAq2kOzMXV20251030105251.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/YWDbrTYBCeHnxXmt7IKnGVtzo3w9Ji20251030105251.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/DENs4eIwgFH8bmOXZU6fY3GbqILllL20251030105253.jpg',
                ],
            ],
            [
                'name' => 'Gran Village do Bosque II',
                'type' => 'condominium',
                'status' => 'available',
                'construction_phase' => 'completed',
                'description' => 'Seu novo jeito de viver entre a vidade e a natureza',
                'address' => 'Rua São Marcos',
                'address_number' => '425',
                'neighborhood' => 'Coaçu',
                'city' => 'Fortaleza',
                'state' => 'CE',
                'total_area' => 12367.30,
                'area' => 0,
                'bedrooms' => 2,
                'suites' => 0,
                'bathrooms' => 0,
                'parking_spaces' => 0,
                'construction' => 'Canopus Construções',
                'program' => 'Minha Casa Minha Vida',
                'features' => ['Swimming Pool', 'Playground', 'Sports Court', 'Gazebo', 'Game Table', 'Pet Place', 'Bike Rack'],
                'images' => [
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/83UjgyxwCdKibptgrOUUKnbeoTNFLy20251031114507.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/5SledB8KeeFEyecO1GYbIiftgnFZmZ20251031114507.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/eMBaKzmKERhyWDrM14fA0VK3UUbJAC20251031114507.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/cAIofiDa1QFn7q4k0cvSK4Di2hBlcW20251031114507.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/IaisWejRhODUJs9KfM4Xv3IjhzndsO20251031114507.jpg',
                ],
            ],
            [
                'name' => 'Gran Village do Sol I',
                'type' => 'condominium',
                'status' => 'available',
                'construction_phase' => 'completed',
                'description' => 'Um futuro com mais conforto, lazer e qualidade de vida para você e sua família está só começando.',
                'address' => 'Rua Joserisse Hortêncio dos Santos',
                'address_number' => '413',
                'neighborhood' => 'Lagoa Redonda',
                'city' => 'Fortaleza',
                'state' => 'CE',
                'total_area' => 16580.29,
                'area' => 40.94,
                'bedrooms' => 2,
                'suites' => 0,
                'bathrooms' => 0,
                'parking_spaces' => 0,
                'construction' => 'Canopus Construções',
                'program' => 'Minha Casa Minha Vida',
                'features' => ['Swimming Pool', 'Party Room', 'Barbecue Area', 'Sports Court', 'Playground', 'Gazebo', 'Game Table', 'Bike Rack'],
                'images' => [
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/3yoi40zbYE2mvoEcv3MNv5XzCXJeAr20251030102131.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/IM8ibo5lMjSqjxV6ez8gejo2xQcjpF20251030102131.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/9uQuRP4Cgbvl1zxgFxQWAbgls5vKtm20251030102131.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/bJJE86xFYYSKX5yiU3Lck6C0OPfx8X20251030102131.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/1S7J7kRBEWtDLnjcDmyXha5uFVJTOO20251030102131.jpg',
                ],
            ],
            [
                'name' => 'Gran Village Maracanaú',
                'type' => 'condominium',
                'status' => 'available',
                'construction_phase' => 'completed',
                'description' => 'O melhor empreendimento de Maracanaú te espera.',
                'address' => 'Rua Luís Gonzaga dos Santos',
                'address_number' => '1555',
                'neighborhood' => 'Jardim Paraíso',
                'city' => 'Maracanaú',
                'state' => 'CE',
                'total_area' => 48324.62,
                'area' => 40.94,
                'bedrooms' => 2,
                'suites' => 0,
                'bathrooms' => 0,
                'parking_spaces' => 1,
                'construction' => 'Canopus Construções',
                'program' => 'Minha Casa Minha Vida',
                'features' => ['Swimming Pool', 'Playground', 'Soccer Field', 'Sports Court', 'Bike Rack'],
                'images' => [
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/rYtklKj10PobfpJbMs0HxSmw6vU7IN20240227000000.webp',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/YN1t4PBxG8NEZhUuVuHYzu38BHsbYz20240227000000.webp',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/FQ4cV5K3vh1u5xyYLEhLMtY4ZtT11620240227000000.webp',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/xG9tJlUjjf4H9a3FrQeyfW2QSZVbPq20240227000000.webp',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/TRN0nl0v9k3Jlv7LFlW8HoN5K8Y1Dv20240227000000.webp',
                ],
            ],
            [
                'name' => 'Gran Village Eusébio III',
                'type' => 'condominium',
                'status' => 'available',
                'construction_phase' => 'completed',
                'description' => 'O Gran Village Eusébio III chegou para te surpreender. Em uma localização privilegiada, um condomínio clube completo com piscina de 20 metros, campo gramado, academia e muito mais!',
                'address' => 'Avenida Santa Cecília',
                'address_number' => '1967',
                'neighborhood' => 'Guaribas',
                'city' => 'Eusébio',
                'state' => 'CE',
                'total_area' => 43619.19,
                'area' => 46.56,
                'bedrooms' => 2,
                'suites' => 1,
                'bathrooms' => 0,
                'parking_spaces' => 1,
                'construction' => 'Canopus Construções',
                'program' => 'Minha Casa Minha Vida',
                'features' => ['Swimming Pool', 'Sports Court', 'Soccer Field', 'Barbecue Area', 'Pet Place', 'Playground', 'Bike Rack', 'Gym', 'Nap Area', 'Elevator'],
                'images' => [
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/SsvAJzkWZ9Odux900CTHQAzXeSXej820240228000000.webp',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/9kBvkToDJ9Fhx7wJ7oVMipDBtYB7nq20240228000000.webp',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/GfXeAMfaFVNJA0VSyx27BwEx0P8dnH20240228000000.webp',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/qbGNXt8Yk08Hkrbvtmg5cbgvMSEsxT20240228000000.webp',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/g67Z9HXSt34U3qwueGTeDPOFqMU1O920240228000000.webp',
                ],
            ],
            [
                'name' => 'Gran Village Juazeiro',
                'type' => 'condominium',
                'status' => 'available',
                'construction_phase' => 'completed',
                'description' => null,
                'address' => 'Anel Viário José Amorim Sobreira',
                'address_number' => '7500',
                'neighborhood' => 'Betolândia',
                'city' => 'Juazeiro do Norte',
                'state' => 'CE',
                'total_area' => 0,
                'area' => 40.94,
                'bedrooms' => 0,
                'suites' => 0,
                'bathrooms' => 0,
                'parking_spaces' => 0,
                'construction' => 'Canopus Construções',
                'program' => 'Minha Casa Minha Vida',
                'features' => ['Swimming Pool', 'Playground', 'Sports Court', 'Soccer Field', 'Gazebo', 'Pet Place', 'Game Table', 'Bike Rack'],
                'images' => [
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/HcZIiAFKx3w7fSL7mtgNquPmIHRpKV20250430164940.png',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/so7t2cfc5qTnbxmojnIKlGmK0vbZjx20250430164939.png',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/Zm49F4V5rOturnXD3c9q6pwmbtBwSi20250430165137.png',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/EDhotHJ7VebKuJ7iLQ66zD4tHERYzc20250430165137.png',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/bpVn3xU6wwfAZ1M6PA3za57Dbta6yq20250430165137.png',
                ],
            ],
            [
                'name' => 'Gran Village Caucaia III',
                'type' => 'condominium',
                'status' => 'available',
                'construction_phase' => 'completed',
                'description' => null,
                'address' => 'Estrada que liga Caucaia a Praia do Pacheco',
                'address_number' => 'S/N',
                'neighborhood' => null,
                'city' => 'Caucaia',
                'state' => 'CE',
                'total_area' => 0,
                'area' => 40.94,
                'bedrooms' => 2,
                'suites' => 0,
                'bathrooms' => 0,
                'parking_spaces' => 0,
                'construction' => 'Canopus Construções',
                'program' => 'Minha Casa Minha Vida',
                'features' => ['Swimming Pool', 'Soccer Field', 'Party Room', 'Barbecue Area', 'Playground', 'Kids Play Room', 'Pet Place', 'Bike Rack', 'Nap Area'],
                'images' => [
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/CeXCCObXnBuC8xlKfvDUeADMma8wUk20250331154249.png',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/8YX6PtrlK60wpF3q2JEa9KAuMttQUs20250331154818.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/jQL7MqqHlLQaLYqD7rZiWPncq9QSti20250331154818.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/EKK3xpOd828Ah3xh2aw6CNfFlf1DH020250331154819.jpg',
                    'https://canopusconstrucoes.com.br/storage/imagens/midias/IytjBKWTzy0tXpRm2qIE6c5tMlCd3a20250331154819.jpg',
                ],
            ],
        ];

        foreach ($properties as $property) {
            $constructionId = Construction::where('name', $property['construction'])->value('id');
            $programId = $property['program'] ?? null
                ? Program::where('name', $property['program'])->value('id')
                : null;
            $brokerId = isset($property['broker'])
                ? Broker::where('name', $property['broker'])->value('id')
                : $defaultBrokerId;

            $model = Property::updateOrCreate(
                ['slug' => Str::slug($property['name'])],
                [
                    'name' => $property['name'],
                    'type' => $property['type'],
                    'status' => $property['status'],
                    'construction_phase' => $property['construction_phase'],
                    'description' => $property['description'],
                    'address' => $property['address'],
                    'address_number' => $property['address_number'],
                    'neighborhood' => $property['neighborhood'],
                    'city' => $property['city'],
                    'state' => $property['state'],
                    'price' => $property['price'] ?? null,
                    'condominium_fee' => $property['condominium_fee'] ?? null,
                    'iptu' => $property['iptu'] ?? null,
                    'total_area' => $property['total_area'],
                    'area' => $property['area'],
                    'bedrooms' => $property['bedrooms'],
                    'suites' => $property['suites'],
                    'bathrooms' => $property['bathrooms'],
                    'parking_spaces' => $property['parking_spaces'],
                    'construction_id' => $constructionId,
                    'program_id' => $programId,
                    'broker_id' => $brokerId,
                    'is_featured' => $property['is_featured'] ?? false,
                    'is_active' => true,
                ],
            );

            $featureIds = Feature::whereIn('name', $property['features'])->pluck('id');
            $model->features()->sync($featureIds);

            foreach ($property['images'] as $index => $url) {
                PropertyImage::updateOrCreate(
                    ['property_id' => $model->id, 'path' => $url],
                    ['sort_order' => $index, 'is_cover' => $index === 0],
                );
            }
        }
    }
}
