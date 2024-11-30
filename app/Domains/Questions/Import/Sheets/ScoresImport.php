<?php

namespace App\Domains\Questions\Import\Sheets;

use App\Domains\Questions\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Questions\Services\QuestionsService;
use App\Helpers\Helpers;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoresImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection): void
    {
        $questionService = Container::getInstance()->get(QuestionsService::class);
        try {
            foreach ($collection as $row) {
                if ($row['unique_id'] == null) {
                    continue;
                }

                $id = (int)Helpers::extractIntegerFromString($row['unique_id']);

                /** @var Question $questionsExists */
                $question = $questionService->getByIdWithRelations($id);

                if ($question) {
                    $questionResponses = $question->getResponses();
                    foreach ($row as $key => $value) {
                        if (str_contains($key, 'response') && $value !== '-') {
                            $response_number = (int)Helpers::extractIntegerFromString($key);
                            $index           = $response_number - 1;
                            $responseDTO     = $questionResponses[$index];

                            /** @var QuestionResponse|null $questionResponse */
                            $questionResponse = QuestionResponse::query()
                                                                ->where('question_id', $question->getId())
                                                                ->where('response_id', $responseDTO->getId())
                                                                ->first();
                            if ($questionResponse) {
                                $questionResponse->score = $value;
                                $questionResponse->save();
                            }
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function headingRow(): int
    {
        return 4;
    }
}
