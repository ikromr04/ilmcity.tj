<?php

namespace App\Models;

use App\Helper;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasTranslations, Publishable;

    protected $guarded = [];

    /** @var list<string> */
    protected array $translatable = ['title', 'excerpt'];

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => Helper::media($this->image, 'images/news.png'));
    }
}
