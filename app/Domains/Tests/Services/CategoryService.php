<?php

namespace App\Domains\Tests\Services;

use App\Domains\Tests\Models\Category;
use App\Domains\Tests\Repositories\CategoryRepositoryInterface;

class CategoryService
{

    private CategoryRepositoryInterface $repository;

    /**
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param string $name
     * @param int|null $parent_id
     * @return Category
     */
    public function firstOrCreate(string $name, ?int $parent_id): Category
    {
        return $this->repository->firstOrCreate($name, $parent_id);
    }

    /**
     * @param string|null $searchTerm
     * @param int $offset
     * @param int $resultCount
     * @return array
     */
    public function categoriesPaginated(?string $searchTerm, int $offset, int $resultCount): array
    {
        return $this->repository->categoriesPaginated($searchTerm, $offset, $resultCount);
    }
}
