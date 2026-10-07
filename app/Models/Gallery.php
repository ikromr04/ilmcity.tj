<?php

namespace App\Models;

use App\Helper;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use Publishable;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'images' => 'array',
        ];
    }

    protected function imageUrls(): Attribute
    {
        return Attribute::get(fn () => array_map(fn ($path) => Helper::media($path), $this->images ?? []));
    }
}
