<?php

namespace App\Domains\Questions\Repositories\Eloquent\Models;

use App\Domains\Instructions\Repositories\Eloquent\Models\Instruction;
use App\Domains\Language\Repositories\Eloquent\Models\Language;
use App\Domains\References\Repositories\Eloquent\Models\Reference;
use App\Domains\Responses\Repositories\Eloquent\Models\Response;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{

    protected $fillable = [
        'title',
        'sort',
        'status',
    ];

    /**
     * @return BelongsToMany
     */
    public function responses() : BelongsToMany
    {
        return $this->belongsToMany(Response::class)->withPivot('score');
    }

    /**
     * @return BelongsToMany
     */
    public function references() : BelongsToMany
    {
        return $this->belongsToMany(Reference::class);
    }

    /**
     * @return BelongsToMany
     */
    public function languages() : BelongsToMany
    {
        return $this->belongsToMany(Language::class)->withPivot('question');
    }

    /**
     * @return BelongsTo
     */
    public function test(): BelongsTo{
        return  $this->belongsTo(Test::class);
    }

    /**
     * @return BelongsTo
     */
    public function subscale(): BelongsTo{
        return  $this->belongsTo(Subscale::class);
    }

    /**
     * @return BelongsTo
     */
    public function instruction(): BelongsTo{
        return  $this->belongsTo(Instruction::class);
    }

    /**
     * @return HasOne
     */
    public function requiredQuestion(): HasOne{
        return  $this->hasOne(Question::class,'id','required_question_id');
    }


    /**
     * @return BelongsToMany
     */
    public function requiredResponses() : BelongsToMany
    {
        return $this->belongsToMany(Response::class,'question_required_response');
    }


    /**
     * @return BelongsToMany
     */
    public function requiredProfessions() : BelongsToMany
    {
        return $this->belongsToMany(Response::class,'question_profession');
    }

}
