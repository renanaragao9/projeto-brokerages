<?php

namespace App\Filament\Resources\PropertyBookings\Pages;

use App\Filament\Resources\PropertyBookings\PropertyBookingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPropertyBooking extends EditRecord
{
    protected static string $resource = PropertyBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon(Heroicon::OutlinedEye),
            DeleteAction::make()
                ->icon(Heroicon::OutlinedTrash),
        ];
    }
}
