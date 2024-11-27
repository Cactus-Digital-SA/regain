<?php

namespace App\Domains\Responses\Repositories\Eloquent\Models;

use App\Domains\Language\Repositories\Eloquent\Models\Language;
use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Response extends Model
{

    protected $fillable = [
        'title',
        'type',
        'sort'
    ];

    /**
     * @return BelongsToMany
     */
    public function languages() :BelongsToMany
    {
        return $this->belongsToMany(Language::class)->withPivot('question');
    }

    /**
     * @return BelongsToMany
     */
    public function questions() : BelongsToMany
    {
        return $this->belongsToMany(Question::class)->withPivot('score');
    }
}
