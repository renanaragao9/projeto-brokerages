<?php

namespace App\Filament\Reports\Construction;

use App\Filament\Reports\Common\BaseReport;
use App\Models\Construction;
use Illuminate\Database\Eloquent\Model;

class ConstructionReport extends BaseReport
{
    public function title(): string
    {
        return 'Relatório de Construtoras';
    }

    public function headers(): array
    {
        return ['Nome', 'E-mail', 'Telefone', 'Website', 'Criado em'];
    }

    public function searchableFields(): array
    {
        return ['name', 'email', 'phone', 'website_url'];
    }

    public function modelClass(): string
    {
        return Construction::class;
    }

    public function mapRow(Model $record): array
    {
        return [
            $record->name,
            $record->email,
            $record->phone,
            $record->website_url,
            $record->created_at?->format('d/m/Y H:i'),
        ];
    }
}
