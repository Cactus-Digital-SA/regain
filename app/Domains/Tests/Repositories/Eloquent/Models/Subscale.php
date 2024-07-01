<?php

namespace App\Domains\Tests\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscale extends Model
{

    protected $fillable = [
        'name',
        'test_id'
    ];

    /**
     * @return BelongsTo
     */
    public function test() :BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * @return HasMany
     */
    public function questions():HasMany
    {
        return $this->hasMany(Question::class);
    }
}
