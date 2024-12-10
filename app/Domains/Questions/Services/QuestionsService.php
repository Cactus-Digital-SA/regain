<?php

namespace App\Domains\Questions\Services;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\QuestionnaireFlow\QuestionnaireFlowService;
use App\Domains\Questions\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\Question as EloquentQuestion;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Questions\Repositories\QuestionRepositoryInterface;
use App\Domains\UserQuestionnaire\Models\UserQuestionnaire;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

readonly class QuestionsService
{
    public function __construct(
        private QuestionRepositoryInterface $repository,
        private QuestionnaireFlowService $questionnaireFlowService,
        private UserQuestionnaireService $userQuestionnaireService,
    ) {
    }

    /**
     * @param Question $entity
     * @return Question|null
     */
    public function store(Question $entity): ?Question
    {
        return $this->repository->store($entity);
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
     * @return Question[]
     */
    public function getAll(): array
    {
        return $this->repository->get();
    }

    /**
     * @param int $id
     * @return Question|null
     */
    public function getByIdWithRelations(int $id): ?Question
    {
        return $this->repository->getByIdWithRelations($id);
    }

    /**
     * @param array $filters
     * @return JsonResponse
     */
    public function dataTable(array $filters = []): \Illuminate\Http\JsonResponse
    {
        return $this->repository->dataTable($filters);
    }

    /**
     * @param Question $entity
     * @param int      $id
     * @return Question|null
     */
    public function update(Question $entity, int $id): ?Question
    {
        return $this->repository->update($entity, $id);
    }

    /**
     * @param Question $entity
     * @return Question|null
     */
    public function attachReferences(Question $entity): ?Question
    {
        return $this->repository->attachReferences($entity);
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
     * @param int $userId
     * @param int $take
     * @return Question[]
     */
    public function fetchQuestions(int $userId, int $take = 10): array
    {
        $questions      = [];
        $activeQuestion = $this->getActiveQuestion($userId);
        if ($activeQuestion === null) {
            return $questions;
        }
        if (!$this->isReadyForSkillsTest() && in_array(
                $activeQuestion->getTest()->getCategoryId(),
                $this->questionnaireFlowService->getFlowCategories(QuestionnaireFlowType::SKILLS)->pluck('id')->toArray(), true)
        ) {
            return $questions;
        }

        $questions[$activeQuestion->getId()] = $activeQuestion;

        $questionLoop = $activeQuestion;
        for ($i = 0; $i < $take; $i++) {
            $nextQuestion = $this->getNextQuestion($questionLoop);

            if ($nextQuestion !== null) {
                $nextCategoryId = $nextQuestion->getTest()->getCategoryId();
                $nextQuestionId = $nextQuestion->getId();

                if (!$this->isReadyForSkillsTest() && in_array(
                        $nextCategoryId,
                        $this->questionnaireFlowService->getFlowCategories(QuestionnaireFlowType::SKILLS)->pluck('id')->toArray(), true)
                ) {
                    continue;
                }
                $questions[$nextQuestionId] = $nextQuestion;
                $questionLoop               = $nextQuestion;
            }
        }

        return $questions;
    }

    public function getLatestAnsweredQuestion(int $userId): ?Question
    {
        /** @var UserResponse|null $latestResponse */
        $latestResponse = UserResponse::query()
                                      ->where('user_id', $userId)
                                      ->orderBy('question_response_id', 'desc')
                                      ->first();

        if ($latestResponse !== null) {
            $activeQuestionId = $latestResponse?->questionResponse->question->id;

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
            $questionResponseQuestionIds = array_map(function ($userResponse) {
                return $userResponse->getId();
            }, $question->getRequiredResponses());
            $questionResponses           = QuestionResponse::query()
                                                           ->where('question_id', '=', $requiredQuestionId)
                                                           ->whereIn('id', $questionResponseQuestionIds)
                                                           ->get("response_id")->toArray();
            $responseIds                 = array_map(function ($response) {
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
        return EloquentQuestion::find($question->getId())->requiredResponses()->first()->question()->first()->id;
    }

    public function getResponseByQuestion(int $questionId): ?UserResponse
    {
        return UserResponse::where("question_id", "=", $questionId)
                           ->where("user_id", "=", Auth::user()->id)
                           ->first();
    }

    private function isReadyForSkillsTest(): bool
    {
        // needs medical history record
        return false;
    }

    public function getNextQuestion(?Question $currentQuestion): ?Question
    {
        $nextQuestionId = null;
        if ($currentQuestion !== null) {
            /** @var EloquentQuestion $question */
            $nextQuestion   = $this->repository->getById($currentQuestion->getId() + 1);
            $nextQuestionId = $nextQuestion?->getId();
        }

        if ($nextQuestionId !== null) {
            $nextQuestion = $this->repository->getById($nextQuestionId);

            return $this->populateHiddenData($nextQuestion);
        }

        return null;
    }

    /**
     * @param int $userId
     * @param int $take
     * @return Question[]
     */
    public function fetchQuestionsAlt(int $userId, int $take = 1): array
    {
        $questionsPool  = $this->getQuestionIdsForPatient($userId);
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

            if (!$found) {
                return $questions;
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

        return $questions;
    }

    /**
     * @param int $userId
     * @return int[]
     */
    private function getQuestionIdsForPatient(int $userId): array
    {
        if (!$this->isReadyForSkillsTest()) {
            $questionIds = $this->userQuestionnaireService->getForUserAndFlow($userId, QuestionnaireFlowType::PRE_ASSESSMENT);
            if (count($questionIds) > 0) {
                return $questionIds;
            }

            $flow      = QuestionnaireFlowType::PRE_ASSESSMENT;
            $questions = EloquentQuestion::whereIn('test_id', function ($query) use ($flow) {
                $query->select('id')
                      ->from('tests')
                      ->whereIn('category_id', function ($subQuery) use ($flow) {
                          $subQuery->select('category_id')
                                   ->from('questionnaire_flows')
                                   ->where('flow_type', $flow->value);
                      });
            })->with(['subscale'])->get();
            // $questions = $this->repository->getByFlow(QuestionnaireFlowType::PRE_ASSESSMENT);
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
                    $sortedQuestions   = $randomQuestions->sortBy('id'); // You can replace 'id' with any field that defines the order in your case.
                    foreach ($sortedQuestions as $sortedQuestion) {
                        $userQuestions[] = $sortedQuestion->id; // Efficiently append using [] operator
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

            return $userQuestions;
        }

        return [];
    }
}
