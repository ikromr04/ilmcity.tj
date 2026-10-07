<?php

namespace App\Models;

use App\Helper;
use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasTranslations;

    protected $guarded = [];

    /** @var list<string> */
    protected array $translatable = ['title', 'description'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => Helper::media($this->image, 'images/cert.png'));
    }
}
