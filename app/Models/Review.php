<?php

namespace App\Models;

use App\Helper;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasTranslations, Publishable;

    protected $guarded = [];

    /** @var list<string> */
    protected array $translatable = ['title', 'text', 'author_name', 'author_caption'];

    protected function photoUrl(): Attribute
    {
        return Attribute::get(fn () => Helper::media($this->photo, 'images/teacher.png'));
    }
}
