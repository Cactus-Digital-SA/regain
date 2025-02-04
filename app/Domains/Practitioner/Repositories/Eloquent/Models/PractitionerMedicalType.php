<?php

namespace App\Domains\Practitioner\Repositories\Eloquent\Models;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Region\Repositories\Eloquent\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PractitionerMedicalType extends Model
{
    protected $table = 'practitioner_medical_type';

    protected $fillable = [
        'practitioner_id',
        'medical_type',
    ];

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class);
    }
}
