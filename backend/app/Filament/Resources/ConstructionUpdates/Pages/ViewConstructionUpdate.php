<?php

namespace App\Filament\Resources\ConstructionUpdates\Pages;

use App\Filament\Resources\ConstructionUpdates\ConstructionUpdateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewConstructionUpdate extends ViewRecord
{
    protected static string $resource = ConstructionUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::OutlinedPencil),
        ];
    }
}
