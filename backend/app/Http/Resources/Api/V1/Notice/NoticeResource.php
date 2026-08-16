<?php

namespace App\Http\Resources\Api\V1\Notice;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NoticeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $noticeableAlias = array_search($this->noticeable_type, Notice::NOTICEABLE_TYPES_ALIASES, strict: true);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->when($request->routeIs('*.notices.show'), $this->content),
            'image_url' => $this->image_path ? $this->resolveImageUrl($this->image_path) : null,
            'media_url' => $this->media_url,
            'published_at' => $this->published_at,
            'noticeable' => $this->whenLoaded('noticeable', fn () => $this->noticeable ? [
                'type' => $noticeableAlias ?: null,
                'id' => $this->noticeable->id,
                'name' => $this->noticeable->name,
            ] : null),
        ];
    }

    /** Aceita tanto path relativo (upload local) quanto URL externa já completa (seed/hotlink). */
    private function resolveImageUrl(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
