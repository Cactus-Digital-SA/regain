<?php

namespace App\Domains\Tests\Jobs;

use App\Domains\Tests\Import\QuestionsImport;
use App\Domains\Tests\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Tests\Repositories\Eloquent\Models\Question;
use App\Domains\Tests\Services\QuestionsService;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
    ) {}

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(): void
    {
        $questionService = new QuestionsService(new EloqQuestionRepository(new Question()));

        $row = $this->question;
        //try {
            $category = (string)$row['category'];
            $subscale = (string)$row['subscale'];
            $test = (string)$row['test'];
            $instructions = (string)$row['instructions'];
            $question = (string)$row['question'];
            $referenceType = (string)$row['reference_group'];
            $referenceGroup = (int)Helpers::extractIntegerFromString($row['reference']);

            /**  Get Responses */
            $responses = [];
            foreach ($row as $key => $value) {
                if (str_contains($key, 'response') && !empty($value)) {
                    $responses[] = (string)$value;
                }
            }

            if ($referenceType == 'Medication Reference') {
                $responses = QuestionsImport::getMedications();
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

            $questionDTO = new \App\Domains\Tests\Models\Question();

            //$questionDTO->setId($id);
            $questionDTO->setTestId($testId);
            $questionDTO->setSubscaleId($subscaleId);
            $questionDTO->setInstructionId($instruction_id);
            $questionDTO->setResponses($responsesIds);

            $questionDTO->setReferences($referencesIds);

            //Todo create or get Languages
            $questionDTO->setLanguages([$language_id => ['question' => $question]]);

            $createdQuestionDTO = $questionService->store($questionDTO);
            //dd($createdQuestionDTO);
            $questionService->syncReferences($questionDTO,$createdQuestionDTO->getId());
        /*}catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }*/
    }

}
