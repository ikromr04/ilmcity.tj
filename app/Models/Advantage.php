<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    use Publishable;

    protected $guarded = [];
}
