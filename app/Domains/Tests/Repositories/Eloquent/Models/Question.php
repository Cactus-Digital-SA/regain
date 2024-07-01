<?php

namespace App\Domains\Tests\Repositories\Eloquent\Models;

use App\Domains\Language\Repositories\Eloquent\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{

    /**
     * @return BelongsToMany
     */
    public function responses() : BelongsToMany
    {
        return $this->belongsToMany(Response::class);
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
}
