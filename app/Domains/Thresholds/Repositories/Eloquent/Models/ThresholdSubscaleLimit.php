<?php

namespace App\Domains\Thresholds\Repositories\Eloquent\Models;

use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThresholdSubscaleLimit extends Model
{
    protected $fillable = [
        'threshold_id',
        'subscale_id',
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

    /**
     * @return BelongsTo
     */
    public function subscale(): BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }
}
