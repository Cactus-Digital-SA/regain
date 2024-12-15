<?php

namespace App\Domains\PatientAssignments\Repositories\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientAssignment extends Model
{
    protected $fillable = [
        'practitioner_user_id',
        'patient_user_id',
    ];

    public function practitionerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'practitioner_user_id');
    }

    public function patientUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_user_id');
    }
}