<?php

namespace App\Filament\Resources\Banks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Dados do Banco')
                    ->description('Bancos parceiros exibidos nas condições de financiamento do imóvel.')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('link_simulation')
                            ->label('Link de simulação')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://banco.com.br/simulador'),

                        FileUpload::make('image_path')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('banks')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('instructions')
                            ->label('Instruções de simulação')
                            ->helperText('Passo a passo de como o cliente deve simular o financiamento neste banco.')
                            ->rows(4)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ]),
            ]);
    }
}
