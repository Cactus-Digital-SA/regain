<?php

namespace App\Domains\Practitioner\Repositories\Eloquent\Models;

use App\Domains\Patient\Models\PatientData;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientAssignments extends Model
{
    protected $table = 'patient_assignments';
    protected $fillable = [
        'practitioner_user_id',
        'patient_user_id',
    ];

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class, 'practitioner_user_id', 'user_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_user_id', 'id');
    }
}