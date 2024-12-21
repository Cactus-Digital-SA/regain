<?php

namespace App\Domains\Reports\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ReportFile extends Model
{
    protected $fillable = [
        'practitioner_user_id',
        'patient_user_id',
        'test_id',
        'uuid'
    ];
}
