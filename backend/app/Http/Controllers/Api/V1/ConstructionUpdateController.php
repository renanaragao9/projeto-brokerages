<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\ConstructionUpdate\StoreConstructionUpdateRequest;
use App\Http\Resources\Api\V1\ConstructionUpdate\ConstructionUpdateResource;
use App\Services\ConstructionUpdate\IndexConstructionUpdateService;
use App\Services\ConstructionUpdate\StoreConstructionUpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConstructionUpdateController extends BaseController
{
    public function index(Request $request, IndexConstructionUpdateService $indexConstructionUpdateService): JsonResponse
    {
        $request->validate([
            'property_id' => ['required', 'integer', 'exists:properties,id'],
        ]);

        return $this->successResponse(
            data: ConstructionUpdateResource::collection(
                $indexConstructionUpdateService->run($request->query('property_id'))
            ),
            message: 'Atualizações da obra listadas com sucesso.'
        );
    }

    public function store(
        StoreConstructionUpdateRequest $storeConstructionUpdateRequest,
        StoreConstructionUpdateService $storeConstructionUpdateService
    ): JsonResponse {
        $data = $storeConstructionUpdateRequest->safe()->except('image');

        $storeConstructionUpdateService->run($data, $storeConstructionUpdateRequest->file('image'));

        return $this->successResponse(
            data: null,
            message: 'Recebemos sua atualização! Ela será exibida no site após aprovação.'
        );
    }
}
