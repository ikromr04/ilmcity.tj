<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    use HasTranslations, Publishable;

    protected $guarded = [];

    /** @var list<string> */
    protected array $translatable = ['title', 'text'];
}
