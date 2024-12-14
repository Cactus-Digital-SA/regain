<?php

namespace App\Domains\UserResponse\Repositories\Eloquent\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    id
 * @property int    user_id
 * @property int    for_user_id
 * @property int    subscale
 * @property int    question_response_id
 * @property int    score
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class UserResponse extends Model
{
    protected $fillable = [
        'user_id',
        'for_user_id',
        'subscale',
        'question_response_id',
        'score'
    ];
    protected $casts = [
        'question_response_id' => 'int',
        'score'                => 'int',
        'user_id'              => 'int',
        'for_user_id'          => 'int',
        'subscale'             => 'int'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to the user for whom the response was created (nullable).
     */
    public function forUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'for_user_id');
    }

    public function questionResponse(): BelongsTo
    {
        return $this->belongsTo(QuestionResponse::class);
    }

    public function subscale(): BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }
}
