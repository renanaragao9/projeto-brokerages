<?php

namespace App\Filament\Resources\Brokers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrokerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Dados do Corretor')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('construction_id')
                            ->label('Construtora')
                            ->relationship('construction', 'name')
                            ->preload()
                            ->nullable(),

                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Telefone')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('website_url')
                            ->label('Website')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('company_name')
                            ->label('Empresa')
                            ->maxLength(255),

                        TextInput::make('creci')
                            ->label('CRECI')
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(3)
                            ->columnSpanFull(),
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

                Toggle::make('is_active')
                    ->label('Ativo')
                    ->default(true),
            ]);
    }
}
