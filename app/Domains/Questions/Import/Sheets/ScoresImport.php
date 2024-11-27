<?php

namespace App\Domains\Questions\Import\Sheets;


use App\Domains\Questions\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Questions\Repositories\Eloquent\Models\Question as EloqQuestion;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\Responses\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Responses\Repositories\Eloquent\Models\Response as EloquentResponse;
use App\Domains\Responses\Services\ResponseService;
use App\Helpers\Helpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ScoresImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection): void
    {
        $responseService = new ResponseService(new EloqResponseRepository(new EloquentResponse()));
        $questionService = new QuestionsService(new EloqQuestionRepository(new EloqQuestion()));
        try {
            foreach ($collection as $row) {
                if($row['unique_id'] == null) continue;

                $id = (int)Helpers::extractIntegerFromString($row['unique_id']);
                $questionsExists = $questionService->getByIdWithRelations($id);

                if($questionsExists) {
                    /**  Get Scores */
                    $questionResponses = $questionsExists->getResponses();
                    foreach ($row as $key => $value) {
                        if (str_contains($key, 'response') && $value != '-') {
                            $response_number = (int)Helpers::extractIntegerFromString($key);
                            $responseDTO = $questionResponses[$response_number-1];
                            $responseService->addScore($responseDTO, $questionsExists->getId(), (string)$value);
                        }
                    }
                }
            }
        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

    }

    public function headingRow(): int
    {
        return 4;
    }
}
