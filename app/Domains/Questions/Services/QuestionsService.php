<?php

namespace App\Domains\Questions\Services;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\QuestionnaireFlow\QuestionnaireFlowService;
use App\Domains\Questions\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\Question as EloquentQuestion;
use App\Domains\Questions\Repositories\QuestionRepositoryInterface;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Http\JsonResponse;

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
    public function fetchQuestions(int $userId, int $take = 5): array
    {
        $questions      = [];
        $activeQuestion = $this->getActiveQuestion($userId);
        if ($activeQuestion === null) {
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

        return $nextQuestionId ? $this->repository->getById($nextQuestionId) : null;
    }

    public function getActiveQuestion(int $userId): ?Question
    {
        /** @var UserResponse|null $currentUserResponse */
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

        return $this->getById($activeQuestionId);
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
