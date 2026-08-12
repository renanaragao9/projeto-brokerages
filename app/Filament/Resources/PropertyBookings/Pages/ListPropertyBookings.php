<?php

namespace App\Filament\Resources\PropertyBookings\Pages;

use App\Filament\Resources\PropertyBookings\PropertyBookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListPropertyBookings extends ListRecords
{
    protected static string $resource = PropertyBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
