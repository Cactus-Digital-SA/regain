<?php

namespace App\Domains\Tests\Repositories\Eloquent\Models;

use App\Domains\Categories\Repositories\Eloquent\Models\Category;
use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Results\Repositories\Eloquent\Models\Threshold;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'sort'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return HasMany
     */
    public function thresholds(): HasMany
    {
        return $this->hasMany(Threshold::class);
    }

    /**
     * @return BelongsToMany
     */
    public function subscales(): BelongsToMany
    {
        return $this->belongsToMany(Subscale::class);
    }
}
