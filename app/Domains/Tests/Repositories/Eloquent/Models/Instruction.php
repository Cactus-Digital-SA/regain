<?php

namespace App\Domains\Tests\Repositories\Eloquent\Models;

use App\Domains\Language\Repositories\Eloquent\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instruction extends Model
{

    protected $fillable = [
        'content',
        'language_id'
    ];

    /**
     * @return BelongsTo
     */
    public function language() : BelongsTo{
        return $this->belongsTo(Language::class);
    }

    /**
     * @return HasMany
     */
    public function questions() : HasMany
    {
        return $this->hasMany(Question::class);
    }
}
