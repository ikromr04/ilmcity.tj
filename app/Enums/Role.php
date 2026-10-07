<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel
{
    case Teacher = 'teacher';
    case Admin = 'admin';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Teacher => 'Преподаватель',
            self::Admin => 'Администрация',
        };
    }
}
