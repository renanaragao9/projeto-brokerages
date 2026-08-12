<?php

namespace App\Filament\Resources\Constructions;

use App\Filament\BaseResource;
use App\Filament\Resources\Constructions\Pages\CreateConstruction;
use App\Filament\Resources\Constructions\Pages\EditConstruction;
use App\Filament\Resources\Constructions\Pages\ListConstructions;
use App\Filament\Resources\Constructions\Pages\ViewConstruction;
use App\Filament\Resources\Constructions\Schemas\ConstructionForm;
use App\Filament\Resources\Constructions\Schemas\ConstructionInfolist;
use App\Filament\Resources\Constructions\Tables\ConstructionsTable;
use App\Models\Construction;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ConstructionResource extends BaseResource
{
    protected static ?string $model = Construction::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $modelLabel = 'Construtora';

    protected static ?string $pluralModelLabel = 'Construtoras';

    protected static ?string $navigationLabel = 'Construtoras';

    protected static string|UnitEnum|null $navigationGroup = 'Catálogos';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ConstructionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ConstructionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConstructionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConstructions::route('/'),
            'create' => CreateConstruction::route('/create'),
            'view' => ViewConstruction::route('/{record}'),
            'edit' => EditConstruction::route('/{record}/edit'),
        ];
    }
}
