<?php

namespace App\Filament\Resources\ConstructionUpdates;

use App\Filament\BaseResource;
use App\Filament\Resources\ConstructionUpdates\Pages\CreateConstructionUpdate;
use App\Filament\Resources\ConstructionUpdates\Pages\EditConstructionUpdate;
use App\Filament\Resources\ConstructionUpdates\Pages\ListConstructionUpdates;
use App\Filament\Resources\ConstructionUpdates\Pages\ViewConstructionUpdate;
use App\Filament\Resources\ConstructionUpdates\Schemas\ConstructionUpdateForm;
use App\Filament\Resources\ConstructionUpdates\Schemas\ConstructionUpdateInfolist;
use App\Filament\Resources\ConstructionUpdates\Tables\ConstructionUpdatesTable;
use App\Models\ConstructionUpdate;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ConstructionUpdateResource extends BaseResource
{
    protected static ?string $model = ConstructionUpdate::class;

    protected static ?string $recordTitleAttribute = 'author_name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCamera;

    protected static ?string $modelLabel = 'Atualização da Obra';

    protected static ?string $pluralModelLabel = 'Atualizações da Obra';

    protected static ?string $navigationLabel = 'Atualizações da Obra';

    protected static string|UnitEnum|null $navigationGroup = 'Imóveis';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ConstructionUpdateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ConstructionUpdateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConstructionUpdatesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConstructionUpdates::route('/'),
            'create' => CreateConstructionUpdate::route('/create'),
            'view' => ViewConstructionUpdate::route('/{record}'),
            'edit' => EditConstructionUpdate::route('/{record}/edit'),
        ];
    }
}
