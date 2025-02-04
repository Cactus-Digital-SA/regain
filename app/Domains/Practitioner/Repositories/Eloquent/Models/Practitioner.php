<?php

namespace App\Domains\Practitioner\Repositories\Eloquent\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Region\Repositories\Eloquent\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Practitioner extends Model
{
    protected $fillable = [
        'user_id',
        'region_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function medicalTypes(): HasMany
    {
        return $this->hasMany(PractitionerMedicalType::class);
    }
}
