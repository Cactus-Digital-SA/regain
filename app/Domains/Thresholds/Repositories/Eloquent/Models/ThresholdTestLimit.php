<?php

namespace App\Domains\Thresholds\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThresholdTestLimit extends Model
{
    protected $fillable = [
        'threshold_id',
        'low',
        'high',
        'label',
        'notes',
    ];

    /**
     * @return BelongsTo
     */
    public function threshold(): BelongsTo
    {
        return $this->belongsTo(Threshold::class);
    }
}
