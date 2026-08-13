<?php

namespace App\Filament\Reports\Program;

use App\Filament\Reports\Common\BaseReport;
use App\Models\Program;
use Illuminate\Database\Eloquent\Model;

class ProgramReport extends BaseReport
{
    public function title(): string
    {
        return 'Relatório de Programas';
    }

    public function headers(): array
    {
        return ['Nome', 'Slug', 'Descrição', 'Criado em'];
    }

    public function searchableFields(): array
    {
        return ['name', 'slug', 'description'];
    }

    public function modelClass(): string
    {
        return Program::class;
    }

    public function mapRow(Model $record): array
    {
        return [
            $record->name,
            $record->slug,
            $record->description,
            $record->created_at?->format('d/m/Y H:i'),
        ];
    }
}
