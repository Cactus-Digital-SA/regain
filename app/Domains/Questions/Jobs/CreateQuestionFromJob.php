<?php

namespace App\Domains\Questions\Jobs;

use App\Domains\Questions\Import\QuestionsImport;
use App\Domains\Questions\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\Responses\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Responses\Repositories\Eloquent\Models\Response;
use App\Domains\Responses\Services\ResponseService;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

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
        $questionService = new QuestionsService(new EloqQuestionRepository(new Question()));
        $responseService = new ResponseService(new EloqResponseRepository(new Response()));

        $row = $this->question;

        $id                = (int)Helpers::extractIntegerFromString($row['unique_id']);
        $category          = (string)$row['category'];
        $subscale          = (string)$row['subscale'];
        $test              = (string)$row['test'];
        $instructions      = (string)$row['instructions'];
        $question          = (string)$row['question'];
        $referenceType     = (string)$row['reference_group'];
        $referenceGroup    = (int)Helpers::extractIntegerFromString($row['reference']);
        $requiredQuestion  = (string)$row['required_question'];
        $requiredResponses = (string)$row['required_response'];

        /**  Get Responses */
        $responses = [];

        if ($referenceType != 'Medication Reference' && $test != 'Professional Sector') {
            foreach ($row as $key => $value) {
                if (str_starts_with($key, "response") && str_contains($key, 'response') && !empty($value)) {
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
        $referencesIds = QuestionsImport::getReferences($referenceType, $referenceGroup);

        /** Required Question and responses for the question to show */
        $requiredResponsesIds = [];
        if ($requiredQuestion != '-') {
            $requiredQuestionId     = (int)Helpers::extractIntegerFromString($row['required_question']);
            $requiredResponsesArray = explode(',', $requiredResponses);

            foreach ($requiredResponsesArray as $requiredResponse) {
                $requiredResponse = $responseService->getByTitle($requiredResponse);

                if ($requiredResponse) {
                    $requiredResponsesIds[] = $requiredResponse->getId();
                }
            }
        } else {
            $requiredQuestionId = null;
        }

        $questionDTO = new \App\Domains\Questions\Models\Question();

        $questionDTO->setTestId($testId);
        $questionDTO->setSubscaleId($subscaleId);
        $questionDTO->setInstructionId($instruction_id);
        $questionDTO->setResponses($responsesIds);
        $questionDTO->setReferences($referencesIds);
        $questionDTO->setTitle($question);
        $questionDTO->setSort(null);
        $questionDTO->setStatus(1);

        $questionDTO->setRequiredQuestionId($requiredQuestionId);
        $questionDTO->setRequiredResponses($requiredResponsesIds);

        $questionDTO->setLanguages([$language_id => ['question' => $question]]);

        $questionService->storeWithId($questionDTO, $id);
    }
}
