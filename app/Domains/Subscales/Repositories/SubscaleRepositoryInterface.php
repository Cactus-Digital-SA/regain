<?php

namespace App\Domains\Subscales\Repositories;

use App\Domains\Subscales\Models\Subscale;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;

interface SubscaleRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Subscale[]|null
     */
    public function get(): ?array;

    /**
     * @param string $id
     * @return Subscale|null
     */
    public function getById(string $id): ?Subscale;

    /**
     * @param string $name
     * @param bool   $withRelations
     * @return Subscale|null
     */
    public function getByName(string $name, bool $withRelations = false): ?Subscale;

    public function store(Subscale|CactusEntity $entity): ?Subscale;

    public function update(Subscale|CactusEntity $entity, string $id): ?Subscale;

    public function subscalesDatatable(array $filters = []): \Illuminate\Http\JsonResponse;

    /**
     * @param string   $name
     * @param int      $test_id
     * @param int      $requiredQuestions
     * @param int|null $sort
     * @return Subscale
     */
    public function findOrCreate(string $name, int $test_id, int $requiredQuestions, ?int $sort): Subscale;
}
