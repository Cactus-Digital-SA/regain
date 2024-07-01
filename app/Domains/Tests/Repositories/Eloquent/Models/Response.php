<?php

namespace App\Domains\Tests\Repositories\Eloquent\Models;

use App\Domains\Language\Repositories\Eloquent\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Response extends Model
{

    protected $fillable = [
        'title',
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
        return $this->belongsToMany(Question::class);
    }
}
