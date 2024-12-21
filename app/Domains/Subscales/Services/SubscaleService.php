<?php

namespace App\Domains\Subscales\Services;

use App\Domains\Subscales\Models\Subscale;
use App\Domains\Subscales\Repositories\SubscaleRepositoryInterface;

class SubscaleService
{
    private SubscaleRepositoryInterface $repository;

    /**
     * @param SubscaleRepositoryInterface $repository
     */
    public function __construct(SubscaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Subscale[]
     */
    public function get(): array
    {
        return $this->repository->get();
    }

    /**
     * @param string $name
     * @param bool   $withRelations
     * @return Subscale|null
     */
    public function getByName(string $name, bool $withRelations = false): ?Subscale
    {
        return $this->repository->getByName($name, $withRelations);
    }

    public function findByNameAndTest(string $name, int $testId, bool $withRelations = false): ?Subscale
    {
        return $this->repository->findByNameAndTest($name, $testId, $withRelations);
    }

    /**
     * @param string   $name
     * @param int      $test_id
     * @param int      $requiredQuestions
     * @param int|null $sort
     * @return Subscale
     */
    public function findOrCreate(string $name, int $test_id, int $requiredQuestions, ?int $sort): Subscale
    {
        return $this->repository->findOrCreate($name, $test_id, $requiredQuestions, $sort);
    }
}
