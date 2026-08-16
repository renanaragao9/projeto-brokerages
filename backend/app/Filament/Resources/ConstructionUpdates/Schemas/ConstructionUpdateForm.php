<?php

namespace App\Filament\Resources\ConstructionUpdates\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ConstructionUpdateForm
{
    public const STATUS_LABELS = [
        'pending' => 'Pendente',
        'approved' => 'Aprovado',
        'rejected' => 'Recusado',
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
                    ]),

                Section::make('Enviado por')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('author_name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('author_email')
                            ->label('E-mail')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('author_phone')
                            ->label('Telefone')
                            ->tel()
                            ->maxLength(255),

                        Textarea::make('message')
                            ->label('Mensagem')
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Imagem')
                            ->image()
                            ->disk('public')
                            ->directory('construction-updates')
                            ->columnSpanFull()
                            ->required(),
                    ]),

                Section::make('Moderação')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options(self::STATUS_LABELS)
                            ->default('pending')
                            ->required()
                            ->live(),

                        Textarea::make('rejection_reason')
                            ->label('Motivo da recusa')
                            ->rows(2)
                            ->visible(fn (Get $get): bool => $get('status') === 'rejected')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
