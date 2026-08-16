<?php

namespace App\Filament\Resources\ConstructionUpdates\Pages;

use App\Filament\Resources\ConstructionUpdates\ConstructionUpdateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListConstructionUpdates extends ListRecords
{
    protected static string $resource = ConstructionUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
