<?php

namespace App\Filament\Resources\ConstructionUpdates\Pages;

use App\Filament\Resources\ConstructionUpdates\ConstructionUpdateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditConstructionUpdate extends EditRecord
{
    protected static string $resource = ConstructionUpdateResource::class;

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
