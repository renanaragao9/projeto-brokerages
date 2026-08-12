<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Users
            ['name' => 'Ver Usuários', 'code' => 'user.view', 'group' => 'Usuários'],
            ['name' => 'Criar Usuários', 'code' => 'user.create', 'group' => 'Usuários'],
            ['name' => 'Editar Usuários', 'code' => 'user.edit', 'group' => 'Usuários'],
            ['name' => 'Atualizar Usuários', 'code' => 'user.update', 'group' => 'Usuários'],
            ['name' => 'Deletar Usuários', 'code' => 'user.delete', 'group' => 'Usuários'],

            // Permissions
            ['name' => 'Ver Permissões', 'code' => 'permission.view', 'group' => 'Permissões'],
            ['name' => 'Criar Permissões', 'code' => 'permission.create', 'group' => 'Permissões'],
            ['name' => 'Editar Permissões', 'code' => 'permission.edit', 'group' => 'Permissões'],
            ['name' => 'Atualizar Permissões', 'code' => 'permission.update', 'group' => 'Permissões'],
            ['name' => 'Deletar Permissões', 'code' => 'permission.delete', 'group' => 'Permissões'],

            // Roles
            ['name' => 'Ver Perfis', 'code' => 'role.view', 'group' => 'Perfis'],
            ['name' => 'Criar Perfis', 'code' => 'role.create', 'group' => 'Perfis'],
            ['name' => 'Editar Perfis', 'code' => 'role.edit', 'group' => 'Perfis'],
            ['name' => 'Atualizar Perfis', 'code' => 'role.update', 'group' => 'Perfis'],
            ['name' => 'Deletar Perfis', 'code' => 'role.delete', 'group' => 'Perfis'],

            // Constructions
            ['name' => 'Ver Construtoras', 'code' => 'construction.view', 'group' => 'Construtoras'],
            ['name' => 'Criar Construtoras', 'code' => 'construction.create', 'group' => 'Construtoras'],
            ['name' => 'Editar Construtoras', 'code' => 'construction.edit', 'group' => 'Construtoras'],
            ['name' => 'Atualizar Construtoras', 'code' => 'construction.update', 'group' => 'Construtoras'],
            ['name' => 'Deletar Construtoras', 'code' => 'construction.delete', 'group' => 'Construtoras'],

            // Brokers
            ['name' => 'Ver Corretores', 'code' => 'broker.view', 'group' => 'Corretores'],
            ['name' => 'Criar Corretores', 'code' => 'broker.create', 'group' => 'Corretores'],
            ['name' => 'Editar Corretores', 'code' => 'broker.edit', 'group' => 'Corretores'],
            ['name' => 'Atualizar Corretores', 'code' => 'broker.update', 'group' => 'Corretores'],
            ['name' => 'Deletar Corretores', 'code' => 'broker.delete', 'group' => 'Corretores'],

            // Programs
            ['name' => 'Ver Programas', 'code' => 'program.view', 'group' => 'Programas'],
            ['name' => 'Criar Programas', 'code' => 'program.create', 'group' => 'Programas'],
            ['name' => 'Editar Programas', 'code' => 'program.edit', 'group' => 'Programas'],
            ['name' => 'Atualizar Programas', 'code' => 'program.update', 'group' => 'Programas'],
            ['name' => 'Deletar Programas', 'code' => 'program.delete', 'group' => 'Programas'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['code' => $permission['code']],
                $permission
            );
        }
    }
}
