<?php

namespace App\Filament\Resources\Constructions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConstructionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados da Construtora')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome'),
                        TextEntry::make('email')
                            ->label('E-mail')
                            ->placeholder('-'),
                        TextEntry::make('phone')
                            ->label('Telefone')
                            ->placeholder('-'),
                        TextEntry::make('website_url')
                            ->label('Website')
                            ->placeholder('-'),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-'),
                        TextEntry::make('is_active')
                            ->label('Ativa')
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
