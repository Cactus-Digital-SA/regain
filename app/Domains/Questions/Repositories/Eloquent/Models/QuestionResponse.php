<?php

namespace App\Domains\Questions\Repositories\Eloquent\Models;

use App\Domains\Responses\Repositories\Eloquent\Models\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionResponse extends Model
{
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
