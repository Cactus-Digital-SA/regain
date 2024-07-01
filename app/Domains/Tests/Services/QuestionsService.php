<?php

namespace App\Domains\Tests\Services;


use App\Domains\Tests\Models\Question;
use App\Domains\Tests\Repositories\QuestionRepositoryInterface;
use App\Models\CactusEntity;
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
     * @param int $id
     * @return Question|null
     */
    public function getById(int $id): ?Question
    {
        return $this->repository->getById($id);
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
     * @param int $id
     * @return Question|null
     */
    public function update(Question $entity, int $id): ?Question{
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
     * @param int $id
     * @return Question|null
     */
    public function syncReferences(Question $entity, int $id): ?Question
    {
        return $this->repository->syncReferences($entity,$id);
    }

}
