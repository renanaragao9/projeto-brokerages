<?php

namespace App\Filament\Resources\Brokers\Tables;

use App\Filament\Filters\Common\CreatedAtFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BrokersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('construction.name')
                    ->label('Construtora')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('creci')
                    ->label('CRECI')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('company_name')
                    ->label('Empresa')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('is_active')
                    ->label('Ativo')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                CreatedAtFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->icon(Heroicon::OutlinedEye),
                EditAction::make()
                    ->icon(Heroicon::OutlinedPencil),
                DeleteAction::make()
                    ->icon(Heroicon::OutlinedTrash),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
