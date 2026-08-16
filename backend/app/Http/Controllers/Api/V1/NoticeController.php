<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\Notice\NoticeResource;
use App\Models\Notice;
use App\Services\Notice\IndexNoticeService;
use App\Services\Notice\ShowNoticeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoticeController extends BaseController
{
    public function index(Request $request, IndexNoticeService $indexNoticeService): JsonResponse
    {
        $request->validate([
            'noticeable_type' => ['nullable', 'string', 'in:'.implode(',', array_keys(Notice::NOTICEABLE_TYPES_ALIASES))],
            'noticeable_id' => ['nullable', 'integer'],
        ]);

        return $this->successResponse(
            data: NoticeResource::collection($indexNoticeService->run(
                $request->query('noticeable_type'),
                $request->query('noticeable_id') ? (int) $request->query('noticeable_id') : null
            )),
            message: 'Notícias listadas com sucesso.'
        );
    }

    public function show(string $slug, ShowNoticeService $showNoticeService): JsonResponse
    {
        $notice = $showNoticeService->run($slug);

        abort_unless($notice, 404);

        return $this->successResponse(
            data: new NoticeResource($notice),
            message: 'Notícia encontrada.'
        );
    }
}
