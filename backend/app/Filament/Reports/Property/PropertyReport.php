<?php

namespace App\Filament\Reports\Property;

use App\Filament\Reports\Common\BaseReport;
use App\Filament\Resources\Properties\Schemas\PropertyForm;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;

class PropertyReport extends BaseReport
{
    public function title(): string
    {
        return 'Relatório de Imóveis';
    }

    public function headers(): array
    {
        return ['Imóvel', 'Tipo', 'Status', 'Preço', 'Cidade', 'UF', 'Corretor', 'Construtora', 'Programa', 'Criado em'];
    }

    public function searchableFields(): array
    {
        return ['name', 'slug', 'city', 'state'];
    }

    public function modelClass(): string
    {
        return Property::class;
    }

    public function mapRow(Model $record): array
    {
        return [
            $record->name,
            PropertyForm::TYPE_LABELS[$record->type] ?? $record->type,
            PropertyForm::STATUS_LABELS[$record->status] ?? $record->status,
            $record->price,
            $record->city,
            $record->state,
            $record->broker?->name,
            $record->construction?->name,
            $record->program?->name,
            $record->created_at?->format('d/m/Y H:i'),
        ];
    }
}
