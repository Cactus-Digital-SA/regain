<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\QuestionnaireFlow\Models\QuestionnaireFlow;
use Illuminate\Database\Seeder;

class QuestionnaireFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionnaireFlows = [
            [
                'category_id' => 1,
                'flow_type'   => QuestionnaireFlowType::PRE_ASSESSMENT->value,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'category_id' => 2,
                'flow_type'   => QuestionnaireFlowType::PRE_ASSESSMENT->value,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'category_id' => 3,
                'flow_type'   => QuestionnaireFlowType::SKILLS->value,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'category_id' => 4,
                'flow_type'   => QuestionnaireFlowType::MEDICAL_HISTORY->value,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        ];

        QuestionnaireFlow::insert($questionnaireFlows);
    }
}
