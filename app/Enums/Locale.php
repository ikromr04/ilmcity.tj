<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Locale: string implements HasLabel
{
    case RU = 'ru';
    case TJ = 'tj';

    public static function default(): self
    {
        return self::tryFrom(config('app.fallback_locale')) ?? self::RU;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::RU => 'Русский',
            self::TJ => 'Тоҷикӣ',
        };
    }
}
