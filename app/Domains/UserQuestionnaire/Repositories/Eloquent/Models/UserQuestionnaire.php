<?php

namespace App\Domains\UserQuestionnaire\Repositories\Eloquent\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuestionnaire extends Model
{
    protected $fillable = [
        'user_id',
        'questionnaire_flow_type',
        'generated_questions',
        'completed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
