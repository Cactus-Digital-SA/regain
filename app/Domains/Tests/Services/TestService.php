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
     * @param string $name
     * @param int $category_id
     * @return Test
     */
    public function findOrCreate(string $name, int $category_id): Test
    {
        return $this->repository->findOrCreate($name, $category_id);
    }

    /**
     * @param string|null $searchTerm
     * @param int $offset
     * @param int $resultCount
     * @return array
     */
    public function testsPaginated(?string $searchTerm, int $offset, int $resultCount): array
    {
        return $this->repository->testsPaginated($searchTerm, $offset, $resultCount);
    }

}
