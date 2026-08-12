<?php

namespace App\Filament\Resources\Properties\RelationManagers;

use App\Models\Feature;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeaturesRelationManager extends RelationManager
{
    protected static string $relationship = 'features';

    protected static ?string $title = 'Características';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Forms definidos nas actions (toolbar/record)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Característica')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->badge()
                    ->searchable(),

                TextColumn::make('value')
                    ->label('Valor')
                    ->placeholder('-')
                    ->getStateUsing(fn (Feature $record): ?string => $record->pivot?->value),

                TextColumn::make('created_at')
                    ->label('Adicionada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(query: fn ($query, string $direction) => $query->orderBy('property_features.created_at', $direction))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('features.id', 'desc')
            ->recordActions([
                EditAction::make()
                    ->form(fn (Schema $schema) => $schema
                        ->schema([
                            TextInput::make('value')
                                ->label('Valor')
                                ->helperText('Opcional, ex: 2, 8, 500m'),
                        ]))
                    ->action(fn (Feature $record, array $data) => $record->pivot?->update($data)),

                DeleteAction::make()
                    ->action(fn (Feature $record) => $this->getOwnerRecord()->features()->detach($record->id)),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Adicionar Característica')
                    ->form(fn (Schema $schema) => $schema
                        ->schema([
                            Select::make('id')
                                ->label('Características')
                                ->options(
                                    Feature::whereNotIn('id', $this->getOwnerRecord()->features()->pluck('features.id'))
                                        ->get()
                                        ->mapWithKeys(fn (Feature $feature) => [$feature->id => $feature->name])
                                )
                                ->searchable()
                                ->multiple()
                                ->required(),

                            TextInput::make('value')
                                ->label('Valor')
                                ->helperText('Opcional, ex: 2, 8, 500m'),
                        ]))
                    ->action(fn (array $data) => $this->getOwnerRecord()->features()->syncWithoutDetaching(
                        collect($data['id'])->mapWithKeys(fn (int $id) => [$id => ['value' => $data['value'] ?? null]])
                    )),
            ]);
    }
}
