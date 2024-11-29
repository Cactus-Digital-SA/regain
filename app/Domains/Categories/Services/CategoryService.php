<?php

namespace App\Domains\Categories\Services;

use App\Domains\Categories\Models\Category;
use App\Domains\Categories\Repositories\CategoryRepositoryInterface;

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
     * @param string   $name
     * @param int|null $parent_id
     * @param int|null $sort
     * @return Category
     */
    public function firstOrCreate(string $name, ?int $parent_id, ?int $sort): Category
    {
        return $this->repository->firstOrCreate($name, $parent_id, $sort);
    }

    /**
     * @param string|null $searchTerm
     * @param int         $offset
     * @param int         $resultCount
     * @return array
     */
    public function categoriesPaginated(?string $searchTerm, int $offset, int $resultCount): array
    {
        return $this->repository->categoriesPaginated($searchTerm, $offset, $resultCount);
    }
}
