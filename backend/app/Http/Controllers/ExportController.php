<?php

namespace App\Http\Controllers;

use App\Filament\Reports\Broker\BrokerReport;
use App\Filament\Reports\Construction\ConstructionReport;
use App\Filament\Reports\Feature\FeatureReport;
use App\Filament\Reports\Permission\PermissionReport;
use App\Filament\Reports\Program\ProgramReport;
use App\Filament\Reports\Property\PropertyReport;
use App\Filament\Reports\PropertyBooking\PropertyBookingReport;
use App\Filament\Reports\Role\RoleReport;
use App\Filament\Reports\User\UserReport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ExportController extends BaseController
{
    public function __invoke(Request $request)
    {
        $resourcePath = $request->query('resource');
        $search = $request->query('search');
        $user = $request->user();

        $report = match ($resourcePath) {
            'property-bookings' => new PropertyBookingReport,
            'properties' => new PropertyReport,
            'features' => new FeatureReport,
            'programs' => new ProgramReport,
            'brokers' => new BrokerReport,
            'constructions' => new ConstructionReport,
            'users' => new UserReport,
            'roles' => new RoleReport,
            'permissions' => new PermissionReport,
            default => abort(404, 'Recurso não encontrado.'),
        };

        return $report->download($user, $search);
    }
}
