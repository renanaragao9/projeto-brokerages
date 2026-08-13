<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\Program\StoreProgramRequest;
use App\Http\Requests\Api\V1\Program\UpdateProgramRequest;
use App\Http\Resources\Api\V1\Program\ProgramResource;
use App\Models\Program;
use App\Services\Program\DestroyProgramService;
use App\Services\Program\IndexProgramService;
use App\Services\Program\StoreProgramService;
use App\Services\Program\UpdateProgramService;
use Illuminate\Http\JsonResponse;

class ProgramController extends BaseController
{
    public function index(IndexProgramService $indexProgramService): JsonResponse
    {
        return $this->successResponse(
            data: ProgramResource::collection($indexProgramService->run()),
            message: 'Empreendimentos listados com sucesso.'
        );
    }

    public function show(Program $program): JsonResponse
    {
        abort_unless($program->is_active, 404);

        return $this->successResponse(
            data: new ProgramResource($program->load('properties')),
            message: 'Empreendimento encontrado.'
        );
    }

    public function store(
        StoreProgramRequest $storeProgramRequest,
        StoreProgramService $storeProgramService
    ): JsonResponse {
        $this->authorize('create', Program::class);

        $data = $storeProgramRequest->validated();
        $program = $storeProgramService->run($data);

        return $this->successResponse(
            data: new ProgramResource($program),
            message: 'Empreendimento criado com sucesso.'
        );
    }

    public function update(
        UpdateProgramRequest $updateProgramRequest,
        Program $program,
        UpdateProgramService $updateProgramService
    ): JsonResponse {
        $this->authorize('update', $program);

        $data = $updateProgramRequest->validated();
        $program = $updateProgramService->run($program, $data);

        return $this->successResponse(
            data: new ProgramResource($program),
            message: 'Empreendimento atualizado com sucesso.'
        );
    }

    public function destroy(Program $program, DestroyProgramService $destroyProgramService): JsonResponse
    {
        $this->authorize('delete', $program);

        $destroyProgramService->run($program);

        return $this->successResponse(
            data: null,
            message: 'Empreendimento removido com sucesso.'
        );
    }
}
