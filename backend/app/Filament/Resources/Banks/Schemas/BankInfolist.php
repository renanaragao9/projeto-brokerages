<?php

namespace App\Filament\Resources\Banks\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BankInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Banco')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome'),
                        TextEntry::make('link_simulation')
                            ->label('Link de simulação')
                            ->placeholder('-')
                            ->url(fn (?string $state): ?string => $state)
                            ->openUrlInNewTab(),
                        ImageEntry::make('image_path')
                            ->label('Logo')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('instructions')
                            ->label('Instruções de simulação')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('is_active')
                            ->label('Ativo')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não'),
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
