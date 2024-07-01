<?php

namespace App\Domains\Tests\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{

    protected $fillable = [
        'name',
        'category_id'
    ];

    public function category() :BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     */
    public function questions():HasMany
    {
        return $this->hasMany(Question::class);
    }
}
