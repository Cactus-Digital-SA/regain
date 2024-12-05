<?php

namespace App\Domains\Questions\Jobs;

use App\Domains\Questions\Import\QuestionsImport;
use App\Domains\Questions\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\Responses\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Responses\Repositories\Eloquent\Models\Response;
use App\Domains\Responses\Services\ResponseService;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateQuestionFromJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Collection $question,
    ) {
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        $questionService = Container::getInstance()->get(QuestionsService::class);
        $responseService = Container::getInstance()->get(ResponseService::class);

        $row = $this->question;

        $id       = (int)Helpers::extractIntegerFromString($row['unique_id']);
        $category = (string)$row['category'];
        $subscale = (string)$row['subscale'];

        if ($category !== "MEDICAL HISTORY") {
            $test           = (string)$row['test'];
            $referenceType  = (string)$row['reference_group'];
            $referenceGroup = (int)Helpers::extractIntegerFromString($row['reference']);
        } else {
            $test          = "MEDICAL HISTORY";
            $referenceType = "MEDICAL HISTORY";
        }

        $instructions = (string)$row['instructions'];
        $question     = (string)$row['question'];

        $requiredQuestion  = array_key_exists('required_question', $row->toArray()) ? $row['required_question'] : null;
        $requiredResponses = array_key_exists('required_response', $row->toArray()) ? $row['required_response'] : null;
        $userInput         = array_key_exists('user_input', $row->toArray()) ? $row['user_input'] ?? false : false;

        /**  Get Responses */
        $responses = [];

        if ($referenceType != 'Medication Reference' && $test != 'Professional Sector') {
            foreach ($row as $key => $value) {
                if (str_starts_with($key, "response") && str_contains($key, 'response') && !empty($value) && $value !== '-') {
                    $responses[] = ['value' => (string)$value, 'type' => 1, 'sort' => null];
                }
            }
        }

        if ($referenceType == 'Medication Reference') {
            $responses  = [];
            $medication = QuestionsImport::getMedications();
            foreach ($medication as $value) {
                $responses[] = ['value' => $value, 'type' => 2, 'sort' => null];
            }
        }

        if ($test == 'Professional Sector') {
            $responses = [];
            foreach ($row as $key => $value) {
                if (str_contains($key, 'response') && !empty($value)) {
                    $responses[] = ['value' => (string)$value, 'type' => 3, 'sort' => null];
                }
            }
        }

        /**  Create or Find Language */
        $language_id = QuestionsImport::findLanguage('en');
        if (!$language_id) {
            throw new Exception('Language not found');
        }

        /**  Create category */
        $categoryId = QuestionsImport::createCategory($category);

        /**  Create Test & Assign Test ID */
        $testId = QuestionsImport::createTest($test, $categoryId);

        /**  Create Subscale & Assign Test ID */
        $subscaleId = QuestionsImport::createSubscale($subscale, $testId);

        /** Instruction Creation */
        $instruction_id = QuestionsImport::createInstruction($instructions, $language_id);

        /**  Create Responses */
        $responsesIds = QuestionsImport::createResponses($responses, $language_id);

        /**  Get References */
        $referencesIds = [];
        if ($category !== "MEDICAL HISTORY") {
            $referencesIds = QuestionsImport::getReferences($referenceType, $referenceGroup);
        }

        /** Required Question and responses for the question to show */
        $requiredResponsesIds = [];
        if ($requiredQuestion && $requiredQuestion !== '-') {
            $requiredQuestionId = (int)Helpers::extractIntegerFromString($row['required_question']);
            if (str_starts_with($requiredResponses, 'RESPONSE')) {
                $requiredResponsesList  = QuestionResponse::where('question_id', $requiredQuestionId)->get("id")->toArray();
                $trimmedResponses       = str_replace(['RESPONSE', '#'], '', $requiredResponses);
                $requiredResponsesArray = explode(',', $trimmedResponses);
                /** @var Collection $requiredResponse */
                $requiredResponsesIds = array_map(function ($index) use ($requiredResponsesList) {
                    return $requiredResponsesList[(int)$index - 1]["id"];  // Subtract 1 to get the correct index
                }, $requiredResponsesArray);
            } else {
                $requiredResponsesArray = explode(',', $requiredResponses);
                foreach ($requiredResponsesArray as $requiredResponse) {
                    $callable = function (Builder $query) use ($requiredResponse) {
                        $query->where(DB::raw("UPPER(title)"), "=", $requiredResponse);
                    };

                    $row = QuestionResponse::where('question_id', $requiredQuestionId)->whereHas("response", $callable)->first();
                    if ($row->count() > 0) {
                        $requiredResponsesIds[] = $row->id;
                    }
                }
            }
        } else {
            $requiredQuestionId = null;
        }

        $questionDTO = new \App\Domains\Questions\Models\Question();

        $questionDTO->setTestId($testId);
        $questionDTO->setSubscaleId($subscaleId);
        $questionDTO->setInstructionId($instruction_id);
        $questionDTO->setReferences($referencesIds);
        $questionDTO->setResponses($responsesIds);
        $questionDTO->setTitle($question);
        $questionDTO->setSort(null);
        $questionDTO->setStatus(1);
        $questionDTO->setRequiredResponses($requiredResponsesIds);
        $questionDTO->setLanguages([$language_id => ['question' => $question]]);
        $questionDTO->setUserInput($userInput);

        $questionService->storeWithId($questionDTO, $id);
    }
}
