<?php

namespace App\Models;

use App\Helper;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasTranslations, Publishable;

    protected $guarded = [];

    /** @var list<string> */
    protected array $translatable = ['title', 'description', 'banner_title', 'banner_text', 'price', 'duration', 'content_title'];

    protected function casts(): array
    {
        return [
            'blocks' => 'array',
        ];
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    protected function bannerUrl(): Attribute
    {
        return Attribute::get(fn () => Helper::media($this->banner, 'images/courses.png'));
    }
}
