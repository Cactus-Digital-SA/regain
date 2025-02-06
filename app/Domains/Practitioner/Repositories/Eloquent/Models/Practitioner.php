<?php

namespace App\Domains\Practitioner\Repositories\Eloquent\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Practitioner\Enums\MedicalPersonnelTypes;
use App\Domains\Region\Repositories\Eloquent\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Practitioner extends Model
{
    protected $fillable = [
        'user_id',
        'region_id',
        'status_id',
        'medical_type_category_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function medicalCategory(): BelongsTo
    {
        return $this->belongsTo(PractitionerMedicalType::class, 'medical_type_category_id', 'type_id');
    }

    public function patientAssignments(): HasMany
    {
        return $this->hasMany(PatientAssignments::class, 'practitioner_user_id', 'user_id');
    }

    public function patients(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class, // Target Model
            PatientAssignments::class, // Intermediate Model
            'practitioner_user_id', // Foreign key on `patient_assignments` table
            'id', // Foreign key on user table
            'user_id', // Local key on `practitioners` table
            'patient_user_id' // Local key on `patient_assignments` table
        );
    }
}
