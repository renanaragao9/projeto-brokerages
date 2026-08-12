<?php

namespace App\Filament\Resources\Brokers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrokerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Corretor')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome'),
                        TextEntry::make('construction.name')
                            ->label('Construtora')
                            ->placeholder('-'),
                        TextEntry::make('email')
                            ->label('E-mail')
                            ->placeholder('-'),
                        TextEntry::make('phone')
                            ->label('Telefone')
                            ->placeholder('-'),
                        TextEntry::make('whatsapp')
                            ->label('WhatsApp')
                            ->placeholder('-'),
                        TextEntry::make('website_url')
                            ->label('Website')
                            ->placeholder('-'),
                        TextEntry::make('company_name')
                            ->label('Empresa')
                            ->placeholder('-'),
                        TextEntry::make('creci')
                            ->label('CRECI')
                            ->placeholder('-'),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->columnSpanFull(),
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
