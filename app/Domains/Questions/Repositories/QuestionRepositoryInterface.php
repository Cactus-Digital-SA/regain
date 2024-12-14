<?php

namespace App\Domains\Questions\Repositories;

use App\Domains\Questions\Models\Question;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\JsonResponse;

interface QuestionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     * @return Question|null
     */
    public function getById(string $id): ?Question;

    /**
     * @param string $id
     * @return Question|null
     */
    public function getByIdWithRelations(string $id): ?Question;

    /**
     * @return Question[]
     */
    public function get(): array;

    /**
     * @param Question|CactusEntity $entity
     * @return Question|null
     */
    public function store(Question|CactusEntity $entity): ?Question;

    /**
     * @param Question|CactusEntity $entity
     * @param string|null           $id
     * @return Question|null
     */
    public function storeWithId(Question|CactusEntity $entity, ?string $id): ?Question;

    /**
     * @param Question|CactusEntity $entity
     * @param string                $id
     * @return Question|null
     */
    public function update(Question|CactusEntity $entity, string $id): ?Question;

    /**
     * @param Question|CactusEntity $entity
     * @return Question|null
     */
    public function attachReferences(Question|CactusEntity $entity): ?Question;

    /**
     * @param Question|CactusEntity $entity
     * @param int                   $id
     * @return Question|null
     */
    public function syncReferences(Question|CactusEntity $entity, int $id): ?Question;

    /**
     * @param array $filters
     * @return JsonResponse
     */
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse;
}
