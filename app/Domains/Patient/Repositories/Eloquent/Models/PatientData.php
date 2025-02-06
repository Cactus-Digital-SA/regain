<?php

namespace App\Domains\Patient\Repositories\Eloquent\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Patient\Enums\StatusEnum;
use App\Domains\Practitioner\Repositories\Eloquent\Models\PatientAssignments;
use App\Domains\Region\Repositories\Eloquent\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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

    public function practitioner(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            PatientAssignments::class,
            'patient_user_id', // Foreign key on patient_assignments table
            'id', // Foreign key on users table
            'user_id', // Local key on patient_data table
            'practitioner_user_id' // Local key on patient_assignments table
        );
    }
}
