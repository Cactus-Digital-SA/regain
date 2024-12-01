<?php

namespace App\Domains\Scores\Repositories\Eloquent;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    id
 * @property int    user_id
 * @property int    subscale_id
 * @property int    score
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class UserSubscaleScore extends Model
{
    protected $fillable = [
        'user_id',
        'subscale_id',
        'score',
    ];
    protected $casts = [
        'user_id'     => 'integer',
        'subscale_id' => 'integer',
        'score'       => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscale(): BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }
}
