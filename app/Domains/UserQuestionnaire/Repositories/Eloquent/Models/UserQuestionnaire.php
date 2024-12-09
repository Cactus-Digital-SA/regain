<?php

namespace App\Domains\UserQuestionnaire\Repositories\Eloquent\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\QuestionnaireFlow\Models\QuestionnaireFlow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuestionnaire extends Model
{
    protected $fillable = [
        'user_id',
        'questionnaire_flow_type',
        'generated_questions',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
