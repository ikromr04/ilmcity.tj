<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    /**
     * Returns the locale prefix if it is not the default locale, or null
     * if the default locale is being used.
     */
    public static function parseLocale(): ?string
    {
        $locale = request()->segment(1);
        $available = config('app.available_locales');
        $default = config('app.locale');

        if ($locale !== $default && in_array($locale, $available)) {
            app()->setLocale($locale);

            return $locale;
        }

        app()->setLocale($default);

        return null;
    }

    /**
     * Resolves a stored file path (public disk) or a public asset into a URL.
     */
    public static function media(?string $path, ?string $fallback = null): ?string
    {
        if (blank($path)) {
            return $fallback ? asset($fallback) : null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}
