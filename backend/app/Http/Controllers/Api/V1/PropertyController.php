<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\Property\PropertyResource;
use App\Models\Property;
use App\Services\Property\IndexPropertyService;
use App\Services\Property\ShowPropertyService;
use Illuminate\Http\JsonResponse;

class PropertyController extends BaseController
{
    public function index(IndexPropertyService $indexPropertyService): JsonResponse
    {
        return $this->successResponse(
            data: PropertyResource::collection($indexPropertyService->run()),
            message: 'Empreendimentos listados com sucesso.'
        );
    }

    public function show(Property $property, ShowPropertyService $showPropertyService): JsonResponse
    {
        abort_unless($property->is_active, 404);

        return $this->successResponse(
            data: new PropertyResource($showPropertyService->run($property)),
            message: 'Empreendimento encontrado.'
        );
    }
}
