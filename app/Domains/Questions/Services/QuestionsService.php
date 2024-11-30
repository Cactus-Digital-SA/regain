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
     * @param int $id
     * @return Question|null
     */
    public function getById(int $id): ?Question
    {
        return $this->repository->getById($id);
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

    public function getActiveQuestion(int $userId): ?EloquentQuestion
    {
        // Get all categories to keep state
        $socioDemoGraphicsCategories = $this->questionnaireFlowService
            ->getFlowCategories(QuestionnaireFlowType::SOCIODEMOGRAPHIC_ASSESSMENT);

        $skillsCategories = $this->questionnaireFlowService
            ->getFlowCategories(QuestionnaireFlowType::SKILLS);

        /** @var UserResponse|null $currentUserResponse */
        $currentUserResponse = UserResponse::query()
                                           ->where('user_id', $userId)
                                           ->orderBy('question_response_id', 'desc')
                                           ->first();

        if ($currentUserResponse !== null) {
            /** @var EloquentQuestion $question */
            $question = $currentUserResponse->questionResponse()->question;
            $nextQuestion = $this->repository->getById($question->question_id + 1);

            if ($nextQuestion === null) {
                $currentCategoryId = $question->test->category_id;

                if (in_array($currentCategoryId, $socioDemoGraphicsCategories->pluck('id')->toArray(), true)) {
                    return null;
                }

                /** @var EloquentQuestion $activeQuestion */
                $activeQuestion = $skillsCategories
                    ->first()
                    ->tests()
                    ->first()
                    ->questions()
                    ->first();

                return $activeQuestion->load(['responses', 'references', 'instructions']);
            }
        }

        $activeQuestion = $socioDemoGraphicsCategories
            ->first()
            ->tests()
            ->first()
            ->questions()
            ->first();

        return $activeQuestion->load(['responses', 'references', 'instructions']);
    }
}
