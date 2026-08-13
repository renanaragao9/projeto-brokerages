<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('storage_url')) {
    function storage_url(?string $path, string $disk = 'public'): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk($disk)->url($path);
    }
}
