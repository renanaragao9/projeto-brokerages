<?php

namespace App\Filament\Reports\Feature;

use App\Filament\Reports\Common\BaseReport;
use App\Models\Feature;
use Illuminate\Database\Eloquent\Model;

class FeatureReport extends BaseReport
{
    public function title(): string
    {
        return 'Relatório de Características';
    }

    public function headers(): array
    {
        return ['Nome', 'Slug', 'Ícone', 'Criado em'];
    }

    public function searchableFields(): array
    {
        return ['name', 'slug', 'icon'];
    }

    public function modelClass(): string
    {
        return Feature::class;
    }

    public function mapRow(Model $record): array
    {
        return [
            $record->name,
            $record->slug,
            $record->icon,
            $record->created_at?->format('d/m/Y H:i'),
        ];
    }
}
