<?php

namespace App\Domains\Tests\Services;

use App\Domains\Tests\Models\Test;
use App\Domains\Tests\Repositories\TestRepositoryInterface;

class TestService
{
    private TestRepositoryInterface $repository;

    /**
     * @param TestRepositoryInterface $repository
     */
    public function __construct(TestRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Test[]
     */
    public function get(): array
    {
        return $this->repository->get();
    }

    /**
     * @param string $name
     * @param bool   $withRelations
     * @return Test|null
     */
    public function getByName(string $name, bool $withRelations = false): ?Test
    {
        return $this->repository->getByName($name, $withRelations);
    }

    /**
     * @param string   $name
     * @param int      $category_id
     * @param int|null $sort
     * @return Test
     */
    public function findOrCreate(string $name, int $category_id, ?int $sort): Test
    {
        return $this->repository->findOrCreate($name, $category_id, $sort);
    }

    /**
     * @param string|null $searchTerm
     * @param int         $offset
     * @param int         $resultCount
     * @return array
     */
    public function testsPaginated(?string $searchTerm, int $offset, int $resultCount): array
    {
        return $this->repository->testsPaginated($searchTerm, $offset, $resultCount);
    }
}
