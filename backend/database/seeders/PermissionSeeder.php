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

            // Features
            ['name' => 'Ver Características', 'code' => 'feature.view', 'group' => 'Características'],
            ['name' => 'Criar Características', 'code' => 'feature.create', 'group' => 'Características'],
            ['name' => 'Editar Características', 'code' => 'feature.edit', 'group' => 'Características'],
            ['name' => 'Atualizar Características', 'code' => 'feature.update', 'group' => 'Características'],
            ['name' => 'Deletar Características', 'code' => 'feature.delete', 'group' => 'Características'],

            // Properties
            ['name' => 'Ver Imóveis', 'code' => 'property.view', 'group' => 'Imóveis'],
            ['name' => 'Criar Imóveis', 'code' => 'property.create', 'group' => 'Imóveis'],
            ['name' => 'Editar Imóveis', 'code' => 'property.edit', 'group' => 'Imóveis'],
            ['name' => 'Atualizar Imóveis', 'code' => 'property.update', 'group' => 'Imóveis'],
            ['name' => 'Deletar Imóveis', 'code' => 'property.delete', 'group' => 'Imóveis'],

            // Property Bookings
            ['name' => 'Ver Agendamentos', 'code' => 'property_booking.view', 'group' => 'Agendamentos'],
            ['name' => 'Criar Agendamentos', 'code' => 'property_booking.create', 'group' => 'Agendamentos'],
            ['name' => 'Editar Agendamentos', 'code' => 'property_booking.edit', 'group' => 'Agendamentos'],
            ['name' => 'Atualizar Agendamentos', 'code' => 'property_booking.update', 'group' => 'Agendamentos'],
            ['name' => 'Deletar Agendamentos', 'code' => 'property_booking.delete', 'group' => 'Agendamentos'],

            // Construction Updates
            ['name' => 'Ver Atualizações da Obra', 'code' => 'construction_update.view', 'group' => 'Atualizações da Obra'],
            ['name' => 'Criar Atualizações da Obra', 'code' => 'construction_update.create', 'group' => 'Atualizações da Obra'],
            ['name' => 'Editar Atualizações da Obra', 'code' => 'construction_update.edit', 'group' => 'Atualizações da Obra'],
            ['name' => 'Atualizar Atualizações da Obra', 'code' => 'construction_update.update', 'group' => 'Atualizações da Obra'],
            ['name' => 'Deletar Atualizações da Obra', 'code' => 'construction_update.delete', 'group' => 'Atualizações da Obra'],

            // Banks
            ['name' => 'Ver Bancos', 'code' => 'bank.view', 'group' => 'Bancos'],
            ['name' => 'Criar Bancos', 'code' => 'bank.create', 'group' => 'Bancos'],
            ['name' => 'Editar Bancos', 'code' => 'bank.edit', 'group' => 'Bancos'],
            ['name' => 'Atualizar Bancos', 'code' => 'bank.update', 'group' => 'Bancos'],
            ['name' => 'Deletar Bancos', 'code' => 'bank.delete', 'group' => 'Bancos'],

            // Notices
            ['name' => 'Ver Notícias', 'code' => 'notice.view', 'group' => 'Notícias'],
            ['name' => 'Criar Notícias', 'code' => 'notice.create', 'group' => 'Notícias'],
            ['name' => 'Editar Notícias', 'code' => 'notice.edit', 'group' => 'Notícias'],
            ['name' => 'Atualizar Notícias', 'code' => 'notice.update', 'group' => 'Notícias'],
            ['name' => 'Deletar Notícias', 'code' => 'notice.delete', 'group' => 'Notícias'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['code' => $permission['code']],
                $permission
            );
        }
    }
}
