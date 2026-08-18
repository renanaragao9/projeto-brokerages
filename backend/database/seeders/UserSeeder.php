<?php

namespace Database\Seeders;

use App\Models\Construction;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        User::updateOrCreate(
            ['email' => 'renanaragao159@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('12345678'),
                'phone' => null,
                'status' => 'active',
                'is_super_admin' => true,
                'role_id' => $adminRole?->id,
                'email_verified_at' => now(),
                'last_login_at' => null,
            ]
        );

        $mateus = User::updateOrCreate(
            ['email' => 'mateusimoveis@seuracha.com'],
            [
                'name' => 'Mateus Imóveis',
                'password' => bcrypt('12345678'),
                'phone' => null,
                'status' => 'active',
                'is_super_admin' => false,
                'role_id' => $adminRole?->id,
                'email_verified_at' => now(),
                'last_login_at' => null,
            ]
        );

        $construction = Construction::where('name', 'Mateus Imóveis')->first();
        if ($construction) {
            $mateus->constructions()->syncWithoutDetaching([$construction->id]);
        }
    }
}
