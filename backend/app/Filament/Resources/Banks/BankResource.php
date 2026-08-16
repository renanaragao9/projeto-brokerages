<?php

namespace App\Filament\Resources\Banks;

use App\Filament\BaseResource;
use App\Filament\Resources\Banks\Pages\CreateBank;
use App\Filament\Resources\Banks\Pages\EditBank;
use App\Filament\Resources\Banks\Pages\ListBanks;
use App\Filament\Resources\Banks\Pages\ViewBank;
use App\Filament\Resources\Banks\Schemas\BankForm;
use App\Filament\Resources\Banks\Schemas\BankInfolist;
use App\Filament\Resources\Banks\Tables\BanksTable;
use App\Models\Bank;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BankResource extends BaseResource
{
    protected static ?string $model = Bank::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?string $modelLabel = 'Banco';

    protected static ?string $pluralModelLabel = 'Bancos';

    protected static ?string $navigationLabel = 'Bancos';

    protected static string|UnitEnum|null $navigationGroup = 'Catálogos';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return BankForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BankInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BanksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBanks::route('/'),
            'create' => CreateBank::route('/create'),
            'view' => ViewBank::route('/{record}'),
            'edit' => EditBank::route('/{record}/edit'),
        ];
    }
}
