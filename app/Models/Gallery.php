<?php

namespace App\Models;

use App\Helper;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasTranslations, Publishable;

    protected $guarded = [];

    /** @var list<string> */
    protected array $translatable = ['title'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'images' => 'array',
        ];
    }

    /**
     * Album items (photos and videos) in display order.
     *
     * @return Attribute<array<int, array{url: string|null, is_video: bool}>, never>
     */
    protected function items(): Attribute
    {
        return Attribute::get(fn () => array_map(fn ($path) => [
            'url' => Helper::media($path),
            'is_video' => Str::endsWith(Str::lower($path), ['.mp4', '.webm', '.mov']),
        ], $this->images ?? []));
    }
}
