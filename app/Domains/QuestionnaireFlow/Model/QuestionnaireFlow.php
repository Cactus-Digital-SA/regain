<?php

namespace App\Domains\QuestionnaireFlow\Model;

use App\Domains\Categories\Models\Category;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireFlow extends Model
{
    protected $fillable = [
        'flow_type',
        'category_id'
    ];

    protected $casts = [
        'flow_type' => QuestionnaireFlowType::class,
    ];
}
