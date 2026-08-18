<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            ConstructionsTableSeeder::class,
            UserSeeder::class,
            BrokersTableSeeder::class,
            BanksTableSeeder::class,
            ProgramSeeder::class,
            FeatureSeeder::class,
            PropertiesTableSeeder::class,
            PropertyFloorPlansTableSeeder::class,
            PropertyBookingsTableSeeder::class,
            NoticesTableSeeder::class,
        ]);
    }
}
