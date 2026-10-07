<?php

namespace App\Models;

use App\Helper;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use Publishable;

    protected $guarded = [];

    protected function logoUrl(): Attribute
    {
        return Attribute::get(fn () => Helper::media($this->logo));
    }
}
