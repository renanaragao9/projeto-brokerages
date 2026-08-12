<?php

namespace App\Filament\Resources\Constructions\Pages;

use App\Filament\Resources\Constructions\ConstructionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListConstructions extends ListRecords
{
    protected static string $resource = ConstructionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
