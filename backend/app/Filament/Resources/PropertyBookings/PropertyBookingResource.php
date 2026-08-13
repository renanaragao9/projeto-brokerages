<?php

namespace App\Filament\Resources\PropertyBookings;

use App\Filament\BaseResource;
use App\Filament\Resources\PropertyBookings\Pages\CreatePropertyBooking;
use App\Filament\Resources\PropertyBookings\Pages\EditPropertyBooking;
use App\Filament\Resources\PropertyBookings\Pages\ListPropertyBookings;
use App\Filament\Resources\PropertyBookings\Pages\ViewPropertyBooking;
use App\Filament\Resources\PropertyBookings\Schemas\PropertyBookingForm;
use App\Filament\Resources\PropertyBookings\Schemas\PropertyBookingInfolist;
use App\Filament\Resources\PropertyBookings\Tables\PropertyBookingsTable;
use App\Models\PropertyBooking;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PropertyBookingResource extends BaseResource
{
    protected static ?string $model = PropertyBooking::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $modelLabel = 'Agendamento';

    protected static ?string $pluralModelLabel = 'Agendamentos';

    protected static ?string $navigationLabel = 'Agendamentos';

    protected static string|UnitEnum|null $navigationGroup = 'Imóveis';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PropertyBookingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PropertyBookingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PropertyBookingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPropertyBookings::route('/'),
            'create' => CreatePropertyBooking::route('/create'),
            'view' => ViewPropertyBooking::route('/{record}'),
            'edit' => EditPropertyBooking::route('/{record}/edit'),
        ];
    }
}
