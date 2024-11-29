<?php

namespace App\Domains\References\Repositories\Eloquent\Models;

use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reference extends Model
{
    protected $fillable = [
        'title',
        'link',
        'group',
        'group_name',
        'type',
    ];

    /**
     * @return BelongsToMany
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }
}
