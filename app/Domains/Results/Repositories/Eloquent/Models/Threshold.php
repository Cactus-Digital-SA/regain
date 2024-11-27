<?php

namespace App\Domains\Results\Repositories\Eloquent\Models;

use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Threshold extends Model
{

    protected $fillable = [
        'interpretation',
        'range_start',
        'range_end',
        'test_id',
        'subscale_id',
    ];

    /**
     * @return BelongsTo
     */
    public function tests() : BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * @return BelongsTo
     */
    public function subscales() : BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }
}
