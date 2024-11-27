<?php

namespace App\Domains\Subscales\Repositories\Eloquent\Models;

use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Results\Repositories\Eloquent\Models\Threshold;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscale extends Model
{

    protected $fillable = [
        'name',
        'test_id',
        'sort',
        'required_questions',
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

    /**
     * @return HasMany
     */
    public function thresholds():HasMany
    {
        return $this->hasMany(Threshold::class);
    }
}
