<?php

namespace App\Filament\Resources\Features\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Dados da Característica')
                    ->description('Características disponíveis em um imóvel ou empreendimento.')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                            ->helperText('Usado na URL pública do anúncio, ex: swimming-pool'),

                        TextInput::make('icon')
                            ->label('Ícone')
                            ->maxLength(255)
                            ->helperText('Identificador do ícone, ex: heroicon name'),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(3)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Ativa')
                            ->default(true),
                    ]),
            ]);
    }
}
