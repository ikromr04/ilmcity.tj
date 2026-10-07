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
        $default = config('app.fallback_locale');

        if ($locale !== $default && in_array($locale, $available)) {
            app()->setLocale($locale);

            return $locale;
        }

        app()->setLocale($default);

        return null;
    }

    /**
     * Picks the value for the given (or current) locale from a ['ru' => ..., 'tj' => ...] array,
     * falling back to the default locale and then to any filled value.
     */
    public static function tr(mixed $value, ?string $locale = null): ?string
    {
        if (! is_array($value)) {
            return $value === null ? null : (string) $value;
        }

        foreach ([$locale ?? app()->getLocale(), config('app.fallback_locale')] as $candidate) {
            if (filled($value[$candidate] ?? null)) {
                return $value[$candidate];
            }
        }

        return collect($value)->first(fn ($item) => filled($item));
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
