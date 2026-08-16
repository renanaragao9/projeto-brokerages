<?php

namespace App\Filament\Resources\Properties\RelationManagers;

use App\Models\Bank;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BanksRelationManager extends RelationManager
{
    protected static string $relationship = 'banks';

    protected static ?string $title = 'Bancos parceiros';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Seleção feita na action de anexar
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Logo')
                    ->disk('public')
                    ->width(60)
                    ->height(40)
                    ->checkFileExistence(false),

                TextColumn::make('name')
                    ->label('Banco')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('link_simulation')
                    ->label('Link de simulação')
                    ->limit(40)
                    ->placeholder('-')
                    ->url(fn (?string $state): ?string => $state)
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('name', 'asc')
            ->headerActions([
                AttachAction::make()
                    ->label('Adicionar Banco')
                    ->recordSelect(fn (Select $select) => $select
                        ->options(
                            Bank::where('is_active', true)
                                ->whereNotIn('id', $this->getOwnerRecord()->banks()->pluck('banks.id'))
                                ->pluck('name', 'id')
                        )
                        ->searchable()),
            ])
            ->recordActions([
                DetachAction::make(),
            ]);
    }
}
