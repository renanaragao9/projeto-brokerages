<?php

namespace App\Services\Notice;

use App\Models\Notice;

class ShowNoticeService
{
    public function run(string $slug): ?Notice
    {
        return Notice::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where(fn ($query) => $query
                ->whereNull('published_at')
                ->orWhere('published_at', '<=', now()))
            ->with('noticeable')
            ->first();
    }
}
