<?php

namespace App\Domains\Language\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'id',
        'name',
        'code',
        'locale',
        'image',
        'status',
    ];
}
