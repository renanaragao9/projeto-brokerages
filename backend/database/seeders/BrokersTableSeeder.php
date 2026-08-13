<?php

namespace Database\Seeders;

use App\Models\Broker;
use Illuminate\Database\Seeder;

class BrokersTableSeeder extends Seeder
{
    public function run(): void
    {
        $brokers = [];

        foreach ($brokers as $name) {
            Broker::updateOrCreate(
                ['name' => $name],
                ['is_active' => true],
            );
        }
    }
}
