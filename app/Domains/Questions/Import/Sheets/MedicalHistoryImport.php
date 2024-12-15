<?php

namespace App\Domains\Questions\Import\Sheets;

use App\Domains\Categories\Repositories\Eloquent\Models\Category;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\Questions\Import\MedicalHistoryQuestionsImport;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicalHistoryImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     * @return void
     * @throws Exception
     */
    public function collection(Collection $collection): void
    {
        MedicalHistoryQuestionsImport::createQuestions($collection);

        $category = Category::where('name', '=', "MEDICAL HISTORY")->first();
        if ($category) {
            DB::table('questionnaire_flows')->insert([
                'category_id' => $category->id,
                'flow_type'   => QuestionnaireFlowType::MEDICAL_HISTORY
            ]);
        }
    }

    public function headingRow(): int
    {
        return 4;
    }
}
