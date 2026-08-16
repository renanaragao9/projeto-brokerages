<?php

namespace App\Filament\Resources\ConstructionUpdates\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConstructionUpdateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Imóvel')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('property.name')
                            ->label('Imóvel'),
                    ]),

                Section::make('Enviado por')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('author_name')
                            ->label('Nome'),
                        TextEntry::make('author_email')
                            ->label('E-mail')
                            ->placeholder('-'),
                        TextEntry::make('author_phone')
                            ->label('Telefone')
                            ->placeholder('-'),
                        TextEntry::make('message')
                            ->label('Mensagem')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        ImageEntry::make('image')
                            ->label('Imagem')
                            ->disk('public')
                            ->columnSpanFull(),
                    ]),

                Section::make('Moderação')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (?string $state): string => ConstructionUpdateForm::STATUS_LABELS[$state] ?? $state ?? '-'),
                        TextEntry::make('rejection_reason')
                            ->label('Motivo da recusa')
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->label('Enviado em')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
