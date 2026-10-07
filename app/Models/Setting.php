<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    /**
     * Reads a setting by dot-notation key, e.g. "contacts.phone".
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Arr::get(static::values(), $key) ?? $default;
    }

    /**
     * Reads a localized setting stored as "{key}.{locale}", falling back to the default locale.
     */
    public static function trans(string $key, mixed $default = null): mixed
    {
        return static::get($key.'.'.app()->getLocale())
            ?? static::get($key.'.'.config('app.fallback_locale'), $default);
    }

    /** @return array<string, mixed> */
    public static function values(): array
    {
        return Cache::rememberForever('settings', fn () => static::query()->pluck('value', 'key')->all());
    }

    /** @param array<string, mixed> $values */
    public static function put(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('settings');
    }
}
