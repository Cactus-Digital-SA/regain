<?php

namespace App\Domains\Thresholds\Repositories\Eloquent\Models;

use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Threshold extends Model
{
    protected $fillable = [
        'test_id',
        'subscale_id',
        'question_start',
        'question_end',
        'display_type',
    ];

    /**
     * @return BelongsTo
     */
    public function tests(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * @return BelongsTo
     */
    public function subscales(): BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }

    public function subscaleLimits(): HasMany
    {
        return $this->hasMany(ThresholdSubscaleLimit::class);
    }
}
