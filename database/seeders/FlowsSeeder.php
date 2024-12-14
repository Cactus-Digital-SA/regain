<?php

namespace Database\Seeders;

use App\Domains\Categories\Repositories\Eloquent\Models\Category;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $category = Category::where('name', '=', "SOCIO-DEMOGRAPHIC & WELLBEING")->first();
        if ($category) {
            DB::table('questionnaire_flows')->insert([
                'category_id' => $category->id,
                'flow_type'   => QuestionnaireFlowType::PRE_ASSESSMENT
            ]);
        }

        $category = Category::where('name', '=', "PRE-ASSESSMENT")->first();
        if ($category) {
            DB::table('questionnaire_flows')->insert([
                'category_id' => $category->id,
                'flow_type'   => QuestionnaireFlowType::PRE_ASSESSMENT
            ]);
        }

        $category = Category::where('name', '=', "SKILLS")->first();
        if ($category) {
            DB::table('questionnaire_flows')->insert([
                'category_id' => $category->id,
                'flow_type'   => QuestionnaireFlowType::SKILLS
            ]);
        }

        $category = Category::where('name', '=', "MEDICAL HISTORY")->first();
        if ($category) {
            DB::table('questionnaire_flows')->insert([
                'category_id' => $category->id,
                'flow_type'   => QuestionnaireFlowType::MEDICAL_HISTORY
            ]);
        }
    }
}
