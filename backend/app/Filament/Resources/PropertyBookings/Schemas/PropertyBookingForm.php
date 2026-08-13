<?php

namespace App\Filament\Resources\PropertyBookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PropertyBookingForm
{
    public const STATUS_LABELS = [
        'pending' => 'Pendente',
        'confirmed' => 'Confirmado',
        'cancelled' => 'Cancelado',
        'completed' => 'Concluído',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Imóvel')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('property_id')
                            ->label('Imóvel')
                            ->relationship('property', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('broker_id')
                            ->label('Corretor')
                            ->relationship('broker', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ]),

                Section::make('Interessado')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Telefone')
                            ->tel()
                            ->required()
                            ->maxLength(255),

                        Textarea::make('message')
                            ->label('Mensagem')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Agendamento')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('scheduled_at')
                            ->label('Data agendada')
                            ->seconds(false),

                        Select::make('status')
                            ->label('Status')
                            ->options(self::STATUS_LABELS)
                            ->default('pending')
                            ->required(),
                    ]),
            ]);
    }
}
