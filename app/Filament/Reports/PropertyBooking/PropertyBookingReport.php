<?php

namespace App\Filament\Reports\PropertyBooking;

use App\Filament\Reports\Common\BaseReport;
use App\Filament\Resources\PropertyBookings\Schemas\PropertyBookingForm;
use App\Models\PropertyBooking;
use Illuminate\Database\Eloquent\Model;

class PropertyBookingReport extends BaseReport
{
    public function title(): string
    {
        return 'Relatório de Agendamentos';
    }

    public function headers(): array
    {
        return ['Imóvel', 'Interessado', 'E-mail', 'Telefone', 'Status', 'Agendado para', 'Criado em'];
    }

    public function searchableFields(): array
    {
        return ['name', 'email', 'phone'];
    }

    public function modelClass(): string
    {
        return PropertyBooking::class;
    }

    public function mapRow(Model $record): array
    {
        return [
            $record->property?->name,
            $record->name,
            $record->email,
            $record->phone,
            PropertyBookingForm::STATUS_LABELS[$record->status] ?? $record->status,
            $record->scheduled_at?->format('d/m/Y H:i'),
            $record->created_at?->format('d/m/Y H:i'),
        ];
    }
}
