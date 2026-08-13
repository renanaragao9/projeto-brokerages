<?php

namespace App\Filament\Resources\PropertyBookings\Pages;

use App\Filament\Resources\PropertyBookings\PropertyBookingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewPropertyBooking extends ViewRecord
{
    protected static string $resource = PropertyBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::OutlinedPencil),
        ];
    }
}
