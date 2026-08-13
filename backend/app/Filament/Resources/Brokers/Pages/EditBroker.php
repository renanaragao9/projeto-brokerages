<?php

namespace App\Filament\Resources\Brokers\Pages;

use App\Filament\Resources\Brokers\BrokerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditBroker extends EditRecord
{
    protected static string $resource = BrokerResource::class;

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
