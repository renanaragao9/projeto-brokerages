<?php

namespace App\Filament\Resources\Constructions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConstructionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Dados da Construtora')
                    ->description('Cadastro de construtoras responsáveis pelos imóveis.')
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
                            ->maxLength(255),

                        TextInput::make('website_url')
                            ->label('Website')
                            ->url()
                            ->maxLength(255),

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
