<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PropertyForm
{
    public const TYPE_LABELS = [
        'apartment' => 'Apartamento',
        'house' => 'Casa',
        'condominium' => 'Condomínio',
        'commercial' => 'Comercial',
        'land' => 'Terreno',
        'development' => 'Empreendimento',
    ];

    public const STATUS_LABELS = [
        'available' => 'Disponível',
        'reserved' => 'Reservado',
        'sold' => 'Vendido',
        'rented' => 'Alugado',
        'unavailable' => 'Indisponível',
    ];

    public const CONSTRUCTION_PHASE_LABELS = [
        'planning' => 'Planejamento',
        'foundation' => 'Fundação',
        'structure' => 'Estrutura',
        'finishing' => 'Acabamento',
        'completed' => 'Concluído',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Dados do Anúncio')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn (?string $state) => str($state ?? '')->slug())
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', str($state ?? '')->slug()))
                            ->helperText('Usado na URL pública do anúncio. Formatado automaticamente (minúsculas, sem espaço/acento).'),

                        Select::make('type')
                            ->label('Tipo')
                            ->options(self::TYPE_LABELS)
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options(self::STATUS_LABELS)
                            ->default('available')
                            ->required(),

                        Select::make('construction_phase')
                            ->label('Fase da obra')
                            ->options(self::CONSTRUCTION_PHASE_LABELS)
                            ->default('planning')
                            ->helperText('Estágio físico da construção, independente do status comercial.'),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Vínculos')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        Select::make('construction_id')
                            ->label('Construtora')
                            ->relationship('construction', 'name')
                            ->preload()
                            ->nullable(),

                        Select::make('broker_id')
                            ->label('Corretor')
                            ->relationship('broker', 'name')
                            ->preload()
                            ->nullable(),

                        Select::make('program_id')
                            ->label('Programa Habitacional')
                            ->relationship('program', 'name')
                            ->preload()
                            ->nullable(),
                    ]),

                Section::make('Informações Financeiras')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('price')
                            ->label('Preço')
                            ->numeric()
                            ->prefix('R$')
                            ->minValue(0),

                        TextInput::make('condominium_fee')
                            ->label('Condomínio')
                            ->numeric()
                            ->prefix('R$')
                            ->minValue(0),

                        TextInput::make('iptu')
                            ->label('IPTU')
                            ->numeric()
                            ->prefix('R$')
                            ->minValue(0),
                    ]),

                Section::make('Características Físicas')
                    ->columnSpanFull()
                    ->columns(5)
                    ->schema([
                        TextInput::make('area')
                            ->label('Área Privativa (m²)')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0),

                        TextInput::make('total_area')
                            ->label('Área Total (m²)')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0),

                        TextInput::make('bedrooms')
                            ->label('Quartos')
                            ->numeric()
                            ->minValue(0)
                            ->integer(),

                        TextInput::make('suites')
                            ->label('Suítes')
                            ->numeric()
                            ->minValue(0)
                            ->integer(),

                        TextInput::make('bathrooms')
                            ->label('Banheiros')
                            ->numeric()
                            ->minValue(0)
                            ->integer(),

                        TextInput::make('parking_spaces')
                            ->label('Vagas')
                            ->numeric()
                            ->minValue(0)
                            ->integer(),
                    ]),

                Section::make('Endereço')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('address')
                            ->label('Endereço')
                            ->maxLength(255)
                            ->columnSpan(2),

                        TextInput::make('address_number')
                            ->label('Número')
                            ->maxLength(255),

                        TextInput::make('address_complement')
                            ->label('Complemento')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('neighborhood')
                            ->label('Bairro')
                            ->maxLength(255),

                        TextInput::make('city')
                            ->label('Cidade')
                            ->maxLength(255),

                        TextInput::make('state')
                            ->label('Estado')
                            ->maxLength(2),

                        TextInput::make('zip_code')
                            ->label('CEP')
                            ->maxLength(20),

                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->step(0.0000001),

                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->step(0.0000001),
                    ]),

                Section::make('Controle do Anúncio')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Destaque'),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ]),
            ]);
    }
}
