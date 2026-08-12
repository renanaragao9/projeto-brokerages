<?php

namespace App\Filament\Resources\Brokers;

use App\Filament\BaseResource;
use App\Filament\Resources\Brokers\Pages\CreateBroker;
use App\Filament\Resources\Brokers\Pages\EditBroker;
use App\Filament\Resources\Brokers\Pages\ListBrokers;
use App\Filament\Resources\Brokers\Pages\ViewBroker;
use App\Filament\Resources\Brokers\Schemas\BrokerForm;
use App\Filament\Resources\Brokers\Schemas\BrokerInfolist;
use App\Filament\Resources\Brokers\Tables\BrokersTable;
use App\Models\Broker;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BrokerResource extends BaseResource
{
    protected static ?string $model = Broker::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $modelLabel = 'Corretor';

    protected static ?string $pluralModelLabel = 'Corretores';

    protected static ?string $navigationLabel = 'Corretores';

    protected static string|UnitEnum|null $navigationGroup = 'Catálogos';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return BrokerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BrokerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrokersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBrokers::route('/'),
            'create' => CreateBroker::route('/create'),
            'view' => ViewBroker::route('/{record}'),
            'edit' => EditBroker::route('/{record}/edit'),
        ];
    }
}
