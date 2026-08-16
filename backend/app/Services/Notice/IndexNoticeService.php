<?php

namespace App\Services\Notice;

use App\Models\Notice;
use Illuminate\Database\Eloquent\Collection;

class IndexNoticeService
{
    public function run(?string $noticeableType = null, ?int $noticeableId = null): Collection
    {
        return Notice::query()
            ->where('is_published', true)
            ->where(fn ($query) => $query
                ->whereNull('published_at')
                ->orWhere('published_at', '<=', now()))
            ->when($noticeableType, fn ($query) => $query->where(
                'noticeable_type',
                Notice::NOTICEABLE_TYPES_ALIASES[$noticeableType] ?? $noticeableType
            ))
            ->when($noticeableId, fn ($query) => $query->where('noticeable_id', $noticeableId))
            ->with('noticeable')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();
    }
}
