<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PropertyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Anúncio')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome')
                            ->columnSpanFull(),
                        TextEntry::make('type')
                            ->label('Tipo')
                            ->formatStateUsing(fn (?string $state): string => PropertyForm::TYPE_LABELS[$state] ?? $state ?? '-'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => PropertyForm::STATUS_LABELS[$state] ?? $state ?? '-'),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('construction.name')
                            ->label('Construtora')
                            ->placeholder('-'),
                        TextEntry::make('broker.name')
                            ->label('Corretor')
                            ->placeholder('-'),
                        TextEntry::make('program.name')
                            ->label('Programa Habitacional')
                            ->placeholder('-'),
                        TextEntry::make('slug')
                            ->label('Slug'),
                    ]),

                Section::make('Informações Financeiras')
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        TextEntry::make('price')
                            ->label('Preço')
                            ->money('BRL')
                            ->placeholder('-'),
                        TextEntry::make('condominium_fee')
                            ->label('Condomínio')
                            ->money('BRL')
                            ->placeholder('-'),
                        TextEntry::make('iptu')
                            ->label('IPTU')
                            ->money('BRL')
                            ->placeholder('-'),
                    ]),

                Section::make('Características Físicas')
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        TextEntry::make('area')
                            ->label('Área Privativa (m²)')
                            ->placeholder('-'),
                        TextEntry::make('total_area')
                            ->label('Área Total (m²)')
                            ->placeholder('-'),
                        TextEntry::make('bedrooms')
                            ->label('Quartos')
                            ->placeholder('-'),
                        TextEntry::make('suites')
                            ->label('Suítes')
                            ->placeholder('-'),
                        TextEntry::make('bathrooms')
                            ->label('Banheiros')
                            ->placeholder('-'),
                        TextEntry::make('parking_spaces')
                            ->label('Vagas')
                            ->placeholder('-'),
                    ]),

                Section::make('Endereço')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        TextEntry::make('address')
                            ->label('Endereço')
                            ->placeholder('-'),
                        TextEntry::make('address_number')
                            ->label('Número')
                            ->placeholder('-'),
                        TextEntry::make('address_complement')
                            ->label('Complemento')
                            ->placeholder('-'),
                        TextEntry::make('neighborhood')
                            ->label('Bairro')
                            ->placeholder('-'),
                        TextEntry::make('city')
                            ->label('Cidade')
                            ->placeholder('-'),
                        TextEntry::make('state')
                            ->label('Estado')
                            ->placeholder('-'),
                        TextEntry::make('zip_code')
                            ->label('CEP')
                            ->placeholder('-'),
                        TextEntry::make('latitude')
                            ->label('Latitude')
                            ->placeholder('-'),
                        TextEntry::make('longitude')
                            ->label('Longitude')
                            ->placeholder('-'),
                    ]),

                Section::make('Situação')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        TextEntry::make('is_featured')
                            ->label('Destaque')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não'),
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
