<?php

namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $guarded = [];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => Helper::media($this->image, 'images/cert.png'));
    }
}
