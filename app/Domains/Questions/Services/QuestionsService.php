<?php

namespace App\Domains\Questions\Services;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\QuestionnaireFlow\QuestionnaireFlowService;
use App\Domains\Questions\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\Question as EloquentQuestion;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Questions\Repositories\QuestionRepositoryInterface;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

readonly class QuestionsService
{
    public function __construct(
        private QuestionRepositoryInterface $repository,
        private QuestionnaireFlowService $questionnaireFlowService,
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

        $questionLoop = $activeQuestion;;
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

    public function getActiveQuestion(int $userId): ?Question
    {
        /** @var UserResponse|null $latestResponse */
        $latestResponse = UserResponse::query()
                                      ->where('user_id', $userId)
                                      ->orderBy('question_response_id', 'desc')
                                      ->first();

        if ($latestResponse !== null) {
            $activeQuestionId = $latestResponse?->questionResponse->question->id + 1;
        } else {
            $activeQuestionId = $this->questionnaireFlowService
                ->getFlowCategories(QuestionnaireFlowType::SOCIODEMOGRAPHIC_ASSESSMENT)
                ->first()
                ->tests()
                ->first()
                ?->questions()
                ->get(["id"])
                ->first()->id;
        }

        $activeQuestion = $this->getById($activeQuestionId);

        return $this->populateHiddenData($activeQuestion);
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

    /**
     * @param int $id
     * @return Question|null
     */
    public function getById(int $id): ?Question
    {
        return $this->repository->getById($id);
    }

    private function isReadyForSkillsTest(): bool
    {
        // needs medical history record
        return false;
    }
}
