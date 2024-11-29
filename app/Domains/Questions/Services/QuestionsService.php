<?php

namespace App\Domains\Questions\Services;

use App\Domains\Questions\Models\Question;
use App\Domains\Questions\Repositories\QuestionRepositoryInterface;
use Illuminate\Http\JsonResponse;

class QuestionsService
{
    private QuestionRepositoryInterface $repository;

    /**
     * @param QuestionRepositoryInterface $repository
     */
    public function __construct(QuestionRepositoryInterface $repository)
    {
        $this->repository = $repository;
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
}
