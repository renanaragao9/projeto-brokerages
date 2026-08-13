<?php

namespace App\Filament\Resources\Properties\RelationManagers;

use App\Models\PropertyImage;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Imagens';

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
                ImageColumn::make('path')
                    ->label('Prévia')
                    ->disk('public')
                    ->width(120)
                    ->height(80)
                    ->checkFileExistence(false)
                    ->alt(fn (PropertyImage $record): string => $record->alt ?? $record->title ?? 'Imagem do imóvel'),

                TextColumn::make('path')
                    ->label('Caminho')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn (PropertyImage $record): string => $record->path)
                    ->url(fn (PropertyImage $record): string => $record->path)
                    ->openUrlInNewTab(),

                TextColumn::make('alt')
                    ->label('Alt')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->sortable(),

                IconColumn::make('is_cover')
                    ->label('Capa')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Adicionada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Editar imagem')
                    ->form(fn (Schema $schema) => $schema
                        ->schema([
                            TextInput::make('alt')
                                ->label('Alt'),

                            TextInput::make('title')
                                ->label('Título'),

                            TextInput::make('sort_order')
                                ->label('Ordem')
                                ->integer()
                                ->default(0),

                            Toggle::make('is_cover')
                                ->label('Capa da galeria'),
                        ]))
                    ->action(function (PropertyImage $record, array $data): void {
                        if (($data['is_cover'] ?? false) && ! $record->is_cover) {
                            $this->getOwnerRecord()->images()->update(['is_cover' => false]);
                        }

                        $record->update($data);
                    }),

                DeleteAction::make()
                    ->action(fn (PropertyImage $record) => $record->forceDelete()),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Adicionar Imagem')
                    ->modalHeading('Nova imagem')
                    ->form(fn (Schema $schema) => $schema
                        ->schema([
                            FileUpload::make('path')
                                ->label('Imagem')
                                ->image()
                                ->disk('public')
                                ->directory(fn (): string => 'properties/'.$this->getOwnerRecord()->id.'/images')
                                ->required(),

                            TextInput::make('alt')
                                ->label('Alt'),

                            TextInput::make('title')
                                ->label('Título'),

                            TextInput::make('sort_order')
                                ->label('Ordem')
                                ->integer()
                                ->default(0),

                            Toggle::make('is_cover')
                                ->label('Capa da galeria'),
                        ]))
                    ->action(function (array $data): void {
                        if ($data['is_cover'] ?? false) {
                            $this->getOwnerRecord()->images()->update(['is_cover' => false]);
                        }

                        $this->getOwnerRecord()->images()->create($data);
                    }),
            ]);
    }
}
