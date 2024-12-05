<?php

namespace App\Domains\Questions\Repositories\Eloquent\Models;

use App\Domains\Instructions\Repositories\Eloquent\Models\Instruction;
use App\Domains\Language\Repositories\Eloquent\Models\Language;
use App\Domains\References\Repositories\Eloquent\Models\Reference;
use App\Domains\Responses\Repositories\Eloquent\Models\Response;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int    id
 * @property string title
 * @property int    instruction_id
 * @property int    subscale_id
 * @property int    test_id
 * @property int    required_question_id
 * @property int    required_response_id
 * @property int    select_multiple
 * @property int    max_selections
 * @property int    sort
 * @property bool   status
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Question extends Model
{
    protected $fillable = [
        'title',
        'instruction_id',
        'subscale_id',
        'test_id',
        'select_multiple',
        'max_selections',
        'required_question_id',
        'user_input',
        'sort',
        'status',
    ];
    protected $casts = [
        'instruction_id'       => 'integer',
        'subscale_id'          => 'integer',
        'test_id'              => 'integer',
        'select_multiple'      => 'boolean',
        'max_selections'       => 'integer',
        'required_question_id' => 'integer',
        'required_response_id' => 'integer',
        'sort'                 => 'integer',
        'user_input'           => 'boolean',
        'status'               => 'boolean',
    ];

    /**
     * @return BelongsToMany
     */
    public function responses(): BelongsToMany
    {
        return $this->belongsToMany(Response::class)->withPivot('score');
    }

    /**
     * @return BelongsToMany
     */
    public function references(): BelongsToMany
    {
        return $this->belongsToMany(Reference::class);
    }

    /**
     * @return BelongsToMany
     */
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class)->withPivot('question');
    }

    /**
     * @return BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * @return BelongsTo
     */
    public function subscale(): BelongsTo
    {
        return $this->belongsTo(Subscale::class);
    }

    /**
     * @return BelongsTo
     */
    public function instruction(): BelongsTo
    {
        return $this->belongsTo(Instruction::class);
    }

    /**
     * @return BelongsToMany
     */
    public function requiredResponses(): BelongsToMany
    {
        return $this->belongsToMany(QuestionResponse::class, 'question_required_response');
    }

    /**
     * @return BelongsToMany
     */
    public function requiredProfessions(): BelongsToMany
    {
        return $this->belongsToMany(Response::class, 'question_profession');
    }
}
