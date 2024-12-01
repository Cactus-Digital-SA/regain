<?php

namespace App\Domains\Scores\Repositories\Eloquent;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    id
 * @property int    user_id
 * @property int    test_id
 * @property int    score
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class UserTestScore extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'score',
    ];
    protected $casts = [
        'score'   => 'integer',
        'user_id' => 'integer',
        'test_id' => 'integer',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
