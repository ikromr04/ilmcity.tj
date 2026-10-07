<?php

namespace App\Models;

use App\Enums\Role;
use App\Helper;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use Publishable;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'role' => Role::class,
        ];
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class)->orderBy('sort')->orderBy('id');
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::get(fn () => Helper::media($this->photo, 'images/teacher.png'));
    }
}
