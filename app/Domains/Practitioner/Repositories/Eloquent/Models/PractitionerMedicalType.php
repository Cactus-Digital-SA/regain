<?php

namespace App\Domains\Practitioner\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PractitionerMedicalType extends Model
{
    protected $table = 'medical_types';
    protected $fillable = [
        'type_id',
        'label',
    ];
    protected $primaryKey = 'type_id';
    public $incrementing = false; // Since `type_id` is manually assigned

    public function practitioners(): HasMany
    {
        return $this->hasMany(Practitioner::class, 'medical_type_category_id', 'type_id');
    }
}
