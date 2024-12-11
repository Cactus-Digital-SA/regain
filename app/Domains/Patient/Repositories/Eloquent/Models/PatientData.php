<?php

namespace App\Domains\Patient\Repositories\Eloquent\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Patient\Enums\StatusEnum;
use App\Domains\Region\Repositories\Eloquent\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientData extends Model
{
    protected $table = 'patient_data';
    protected $fillable = [
        'user_id',
        'birthday',
        'region_id',
        'post_code',
        'primary_phone',
        'secondary_phone',
        'accessible_mobility',
        'notes',
        'status'
    ];
    protected $casts = [
        'status' => StatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
