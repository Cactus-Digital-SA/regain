<?php

namespace App\Domains\Questions\Repositories\Eloquent\Models;

use App\Domains\Responses\Repositories\Eloquent\Models\Response;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    id
 * @property int    question_id
 * @property int    response_id
 * @property int    score
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class QuestionResponse extends Model
{
    protected $table = 'question_response';
    protected $fillable = [
        'question_id',
        'response_id',
        'score',
    ];
    protected $casts = [
        'score'       => 'integer',
        'response_id' => 'integer',
        'question_id' => 'integer',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }
}
