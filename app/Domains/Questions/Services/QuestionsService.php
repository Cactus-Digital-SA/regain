<?php

namespace App\Domains\Questions\Services;

use App\Domains\Auth\Services\UserService;
use App\Domains\Patient\Enums\StatusEnum;
use App\Domains\Patient\Services\PatientDataService;
use App\Domains\PatientAssignments\Services\PatientAssignmentService;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\Questions\Models\Question;
use App\Domains\Questions\Models\QuestionsPresenter;
use App\Domains\Questions\Repositories\Eloquent\Models\Question as EloquentQuestion;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Questions\Repositories\QuestionRepositoryInterface;
use App\Domains\Reports\Dtos\MedicalHistoryReport\MedicalHistoryQuestionAnswer;
use App\Domains\Reports\Dtos\MedicalHistoryReport\MedicalHistoryResult;
use App\Domains\UserQuestionnaire\Models\UserQuestionnaire;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

readonly class QuestionsService
{
    public function __construct(
        private QuestionRepositoryInterface $repository,
        private UserQuestionnaireService $userQuestionnaireService,
        private PatientAssignmentService $patientAssignmentService,
        private PatientDataService $patientDataService,
        private UserService $userService,
    ) {
    }

    /**
     * @param array $filters
     * @return JsonResponse
     */
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        return $this->repository->dataTable($userId, $filters);
    }

    /**
     * @param int $userId
     * @param int $take
     * @return QuestionsPresenter
     */
    public function fetchQuestionsAlt(int $userId, int $take = 1): QuestionsPresenter
    {
        $presenter = new QuestionsPresenter();

        $flow = $this->getFlowTypeForUser($userId);

        $presenter->setType($flow);

        $questionsPool  = $this->getQuestionIdsForPatient($userId, $flow);
        $activeQuestion = $this->getLatestAnsweredQuestion($userId);
        $questions      = [];

        $index = 0;
        if ($activeQuestion !== null) {
            $found = false;
            foreach ($questionsPool as $i => $value) {
                if ($value > $activeQuestion->getId()) {
                    $index = $i;
                    $found = true;
                    break;
                }
            }

            if (!$found && $questionsPool[count($questionsPool) - 1] === $activeQuestion->getId()) {
                // complete flow
                // this needs to be re-worked to take in account the edge case
                // that the last question is conditional, fine for now
                $this->userQuestionnaireService->setCompleted($userId, $flow, true);
                if ($flow === QuestionnaireFlowType::PRE_ASSESSMENT) {
                    $this->patientAssignmentService->assignPatientByRegion($userId);
                    // update the status
                    $this->patientDataService->updateStatus($userId, StatusEnum::ALLOCATED);
                }

                return $presenter->setQuestions([])->setCompleted(true);
            }
        }

        if ($take + $index > count($questionsPool)) {
            $take = (int)(count($questionsPool) - $index);
        }

        $questionsToAsk = array_slice($questionsPool, $index, $take);
        foreach ($questionsToAsk as $questionId) {
            $question = $this->getById($questionId);
            $this->populateHiddenData($question);
            $questions[] = $question;
        }

        return $presenter->setQuestions($questions)->setCompleted(false);
    }

    private function getFlowTypeForUser(int $userId): QuestionnaireFlowType
    {
        if (!$this->isReadyForSkillsTest($userId)) {
            return QuestionnaireFlowType::PRE_ASSESSMENT;
        }

        return QuestionnaireFlowType::SKILLS;
    }

    private function isReadyForSkillsTest(int $userId): bool
    {
        $preAssessment  = $this->userQuestionnaireService->getCompleted($userId, QuestionnaireFlowType::PRE_ASSESSMENT);
        $medicalHistory = $this->userQuestionnaireService->getMedicalHistoryCompletedForUser($userId);

        return $preAssessment && $medicalHistory;
    }

    /**
     * @param int                   $userId
     * @param QuestionnaireFlowType $flow
     * @return int[]
     */
    private function getQuestionIdsForPatient(int $userId, QuestionnaireFlowType $flow): array
    {

        $questionIds = $this->userQuestionnaireService->getForUserAndFlow($userId, $flow);
        if (count($questionIds) > 0) {
            return $questionIds;
        }

        $questions                = EloquentQuestion::whereIn('test_id', static function ($query) use ($flow) {
            $query->select('id')
                  ->from('tests')
                  ->whereIn('category_id', function ($subQuery) use ($flow) {
                      $subQuery->select('category_id')
                               ->from('questionnaire_flows')
                               ->where('flow_type', $flow->value);
                  });
        })->with(['subscale'])->orderBy("id")->get();
        $userQuestions            = [];
        $randomSubscalesProcessed = [];
        foreach ($questions as $question) {
            if ($question->subscale_id !== null && array_key_exists($question->subscale_id, $randomSubscalesProcessed)) {
                continue;
            }

            if (
                $question->subscale !== null &&
                $question->subscale->required_questions > 0
            ) {
                $subscaleQuestions = $question->subscale->questions;
                $requiredCount     = $question->subscale->required_questions;
                $randomQuestions   = $subscaleQuestions->shuffle()->take($requiredCount);
                $sortedQuestions   = $randomQuestions->sortBy('id');
                foreach ($sortedQuestions as $sortedQuestion) {
                    $userQuestions[] = $sortedQuestion->id;
                }
                $randomSubscalesProcessed[$question->subscale_id] = true;
            } else {
                $userQuestions[] = $question->id;
            }
        }

        $this->userQuestionnaireService->store(
            (new UserQuestionnaire())
                ->setUserId($userId)
                ->setQuestionnaireFlowType($flow)
                ->setQuestionIds($userQuestions)
        );

        if ($flow === QuestionnaireFlowType::PRE_ASSESSMENT) {
            $this->patientDataService->updateStatus($userId, StatusEnum::PROCESSING);
        }

        return $userQuestions;
    }

    /**
     * @param Question $entity
     * @return Question|null
     */
    public function store(Question $entity): ?Question
    {
        return $this->repository->store($entity);
    }

    public function getLatestAnsweredQuestion(int $userId): ?Question
    {
        /** @var UserResponse|null $latestResponse */
        $latestResponse = UserResponse::query()
                                      ->where('user_id', $userId)
                                      ->orderBy('question_response_id', 'desc')
                                      ->first();

        if ($latestResponse !== null) {
            $activeQuestionId = $latestResponse->questionResponse->question->id;

            return $this->getById($activeQuestionId);
        }

        return null;
    }

    /**
     * @param int $id
     * @return Question|null
     */
    public function getById(int $id): ?Question
    {
        return $this->repository->getById($id);
    }

    private function populateHiddenData(?Question $question): ?Question
    {
        if ($question && count($question->getRequiredResponses()) > 0) {
            $requiredQuestionId       = $this->getRequiredQuestionId($question);
            $requiredQuestionResponse = $this->getResponseByQuestion($requiredQuestionId);
            $question->setRequiredQuestionId($requiredQuestionId);
            $questionResponseQuestionIds = array_map(static function ($userResponse) {
                return $userResponse->getId();
            }, $question->getRequiredResponses());
            $questionResponses           = QuestionResponse::query()
                                                           ->where('question_id', '=', $requiredQuestionId)
                                                           ->whereIn('id', $questionResponseQuestionIds)
                                                           ->get("response_id")->toArray();
            $responseIds                 = array_map(static function ($response) {
                return $response["response_id"];
            }, $questionResponses);
            $question->setRequiredQuestionResponses($responseIds);
            if ($requiredQuestionResponse && in_array($requiredQuestionResponse->question_response_id, $questionResponseQuestionIds, true)) {
                $question->setHiddenBecauseOfRequired(false);
            } else {
                $question->setHiddenBecauseOfRequired(true);
            }
        }

        return $question;
    }

    private function getRequiredQuestionId(Question $question): ?int
    {
        return EloquentQuestion::find($question->getId())?->requiredResponses()->first()?->question()->first()->id;
    }

    public function getResponseByQuestion(int $questionId): ?UserResponse
    {
        return UserResponse::where("question_id", "=", $questionId)
                           ->where("user_id", "=", Auth::user()->id)
                           ->first();
    }

    /**
     * @param int $userId
     * @param int $take
     * @return QuestionsPresenter
     */
    public function fetchMedicalHistoryQuestions(int $userId, int $forUserId, int $take = 2): QuestionsPresenter
    {
        $presenter = new QuestionsPresenter();

        $flow = QuestionnaireFlowType::MEDICAL_HISTORY;

        $presenter->setType($flow);

        $activeQuestion = $this->getLatestAnsweredMedicalHistoryQuestion($userId, $forUserId);
        $questions      = $this->getMedicalHistoryQuestions($take, $activeQuestion?->getId() ?? 0);
        foreach ($questions as $question) {
            $this->populateHiddenData($question);
        }

        $completed = false;
        if ($activeQuestion && $questions === []) {
            if (!$this->userQuestionnaireService->getCompletedForUser($userId, $forUserId, $flow)) {
                $this->userQuestionnaireService->setCompletedForUser($userId, $forUserId, $flow, true);
            }

            $completed = true;
        }

        return $presenter->setQuestions($questions)->setCompleted($completed);
    }

    public function getLatestAnsweredMedicalHistoryQuestion(int $userId, int $forUserId): ?Question
    {
        /** @var UserResponse|null $latestResponse */
        $latestResponse = UserResponse::query()
                                      ->where('user_id', $userId)
                                      ->where('for_user_id', $forUserId)
                                      ->orderBy('question_id', 'desc')
                                      ->first();

        if ($latestResponse !== null) {
            $activeQuestionId = $latestResponse->question_id;

            return $this->getById($activeQuestionId);
        }

        return null;
    }

    public function getMedicalHistoryQuestions(int $take = 2, int $startFrom = 0): array
    {
        $eloqQuestions = EloquentQuestion::whereIn('test_id', static function ($query) {
            $query->select('id')
                  ->from('tests')
                  ->whereIn('category_id', function ($subQuery) {
                      $subQuery->select('category_id')
                               ->from('questionnaire_flows')
                               ->where('flow_type', QuestionnaireFlowType::MEDICAL_HISTORY->value);
                  });
        });

        if ($startFrom > 0) {
            $eloqQuestions = $eloqQuestions->where('id', '>', $startFrom);
        }

        $eloqQuestions = $eloqQuestions->orderBy("id")->take($take)->get();

        $questions = [];
        foreach ($eloqQuestions as $question) {
            $questions[] = $this->getById($question->id);
        }

        return $questions;
    }

    /**
     * @param Question    $entity
     * @param string|null $id
     * @return Question|null
     */
    public function storeWithId(Question $entity, ?string $id): ?Question
    {
        return $this->repository->storeWithId($entity, $id);
    }

    /**
     * @param Question $entity
     * @param int      $id
     * @return Question|null
     */
    public function syncReferences(Question $entity, int $id): ?Question
    {
        return $this->repository->syncReferences($entity, $id);
    }

    /**
     * @param int $id
     * @return Question|null
     */
    public function getByIdWithRelations(int $id): ?Question
    {
        return $this->repository->getByIdWithRelations($id);
    }

    public function getMedicalHistoryReportForPatient(int $userId, int $patientId): MedicalHistoryResult
    {
        $questions = $this->getMedicalHistoryQuestions(take: PHP_INT_MAX, startFrom: 0);
        $result    = new MedicalHistoryResult();

        // Iterate over the questions to collect their responses
        foreach ($questions as $question) {
            // Retrieve the response for the current question
            $response = UserResponse::query()
                                    ->where('user_id', '=', $userId)
                                    ->where('for_user_id', '=', $patientId)
                                    ->where('question_id', '=', $question->getId())
                                    ->first();

            // Add the question and corresponding response to the report
            $answer = (new MedicalHistoryQuestionAnswer())
                ->setQuestionText($question->getTitle());

            if ($response) {
                if ($response?->question_response_id) {
                    $questionResponse = QuestionResponse::where([
                            'id' => $response->question_response_id,
                        ]
                    )->first();
                    $answer->setAnswerText(
                        $questionResponse->response->title
                    );
                }
                else {
                    $answer->setAnswerText($response->text);
                }
            } else {
                continue;
            }

            $result->addQuestionAnswer($answer);
        }

        $result->setCompletedAt($this->userQuestionnaireService->getCompletedAtForUser($userId, $patientId, QuestionnaireFlowType::MEDICAL_HISTORY));

        $result->setPatientData($this->patientDataService->getByUserId($patientId));

        return $result;
    }
}
