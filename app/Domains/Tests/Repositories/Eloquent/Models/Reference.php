<?php

namespace App\Domains\Tests\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reference extends Model
{

    protected $fillable = [
        'title',
        'group',
        'type',
    ];

    public function questions():BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }
}
