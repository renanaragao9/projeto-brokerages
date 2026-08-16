<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Role;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Dados do Usuário')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Avatar')
                            ->image()
                            ->directory('avatars')
                            ->columnSpanFull(),

                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),

                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->required(),

                        TextInput::make('phone')
                            ->label('Telefone')
                            ->mask('(99) 9-9999-9999')
                            ->nullable(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Ativo',
                                'inactive' => 'Inativo',
                            ])
                            ->nullable(),

                        Select::make('role_id')
                            ->label('Perfil')
                            ->options(fn () => Role::query()->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),

                        Select::make('constructions')
                            ->label('Empresas')
                            ->relationship('constructions', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->helperText('Empresas que este usuário pode ver no painel. Super admin enxerga tudo, independente disso. Sem nenhuma empresa selecionada, o usuário não vê imóveis, corretores, agendamentos ou atualizações de obra.')
                            ->columnSpanFull(),

                        DateTimePicker::make('email_verified_at')
                            ->label('E-mail verificado em'),

                        TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->required(fn ($record) => $record === null)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
