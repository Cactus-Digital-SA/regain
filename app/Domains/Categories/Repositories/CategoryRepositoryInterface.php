<?php

namespace App\Domains\Categories\Repositories;

use App\Domains\Categories\Models\Category;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string   $name
     * @param int|null $parent_id
     * @param int|null $sort
     * @return Category
     */
    public function firstOrCreate(string $name, ?int $parent_id, ?int $sort): Category;

    /**
     * @param string|null $searchTerm
     * @param int         $offset
     * @param int         $resultCount number of results per page
     * @return array{data: Collection, count: int} Array contains paginated data and total count.
     */
    public function categoriesPaginated(?string $searchTerm, int $offset, int $resultCount): array;
}
