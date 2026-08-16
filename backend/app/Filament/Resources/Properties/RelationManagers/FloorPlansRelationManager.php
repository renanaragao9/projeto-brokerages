<?php

namespace App\Filament\Resources\Properties\RelationManagers;

use App\Models\PropertyFloorPlan;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FloorPlansRelationManager extends RelationManager
{
    protected static string $relationship = 'floorPlans';

    protected static ?string $title = 'Plantas e tour 3D';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Forms definidos nas actions (toolbar/record)
            ]);
    }

    protected function fields(): array
    {
        return [
            TextInput::make('title')
                ->label('Título')
                ->placeholder('Ex: Planta 2 quartos, Tour virtual da suíte')
                ->maxLength(255)
                ->columnSpanFull(),

            FileUpload::make('image_path')
                ->label('Imagem da planta')
                ->image()
                ->disk('public')
                ->directory(fn (): string => 'properties/'.$this->getOwnerRecord()->id.'/floor-plans')
                ->requiredWithout('tour_url')
                ->columnSpanFull(),

            TextInput::make('tour_url')
                ->label('Link do tour 3D / 360°')
                ->url()
                ->maxLength(255)
                ->placeholder('https://my.matterport.com/show/?m=...')
                ->helperText('Link de um tour virtual (Matterport, Kuula, YouTube 360 etc). Preencha isso ou a imagem acima — ou os dois.')
                ->requiredWithout('image_path')
                ->columnSpanFull(),

            TextInput::make('sort_order')
                ->label('Ordem')
                ->integer()
                ->default(0),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Prévia')
                    ->disk('public')
                    ->width(120)
                    ->height(80)
                    ->checkFileExistence(false),

                TextColumn::make('title')
                    ->label('Título')
                    ->placeholder('-')
                    ->searchable(),

                TextColumn::make('tour_url')
                    ->label('Tour 3D')
                    ->limit(30)
                    ->placeholder('-')
                    ->url(fn (?string $state): ?string => $state)
                    ->openUrlInNewTab(),

                TextColumn::make('sort_order')
                    ->label('Ordem')
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
                    ->modalHeading('Editar planta')
                    ->form(fn (Schema $schema) => $schema->schema($this->fields())),

                DeleteAction::make()
                    ->action(fn (PropertyFloorPlan $record) => $record->forceDelete()),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Adicionar Planta')
                    ->modalHeading('Nova planta / tour 3D')
                    ->form(fn (Schema $schema) => $schema->schema($this->fields()))
                    ->action(fn (array $data) => $this->getOwnerRecord()->floorPlans()->create($data)),
            ]);
    }
}
