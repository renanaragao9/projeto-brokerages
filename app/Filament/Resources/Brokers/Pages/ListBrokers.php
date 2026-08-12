<?php

namespace App\Filament\Resources\Brokers\Pages;

use App\Filament\Resources\Brokers\BrokerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListBrokers extends ListRecords
{
    protected static string $resource = BrokerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
