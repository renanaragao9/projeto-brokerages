<?php

namespace App\Filament\Reports\Broker;

use App\Filament\Reports\Common\BaseReport;
use App\Models\Broker;
use Illuminate\Database\Eloquent\Model;

class BrokerReport extends BaseReport
{
    public function title(): string
    {
        return 'Relatório de Corretores';
    }

    public function headers(): array
    {
        return ['Nome', 'Construtora', 'Empresa', 'CRECI', 'Cidade', 'Telefone', 'Criado em'];
    }

    public function searchableFields(): array
    {
        return ['name', 'email', 'phone', 'creci', 'company_name', 'city'];
    }

    public function modelClass(): string
    {
        return Broker::class;
    }

    public function mapRow(Model $record): array
    {
        return [
            $record->name,
            $record->construction?->name,
            $record->company_name,
            $record->creci,
            $record->city,
            $record->phone,
            $record->created_at?->format('d/m/Y H:i'),
        ];
    }
}
