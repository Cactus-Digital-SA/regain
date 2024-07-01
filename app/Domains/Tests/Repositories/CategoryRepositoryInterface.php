<?php

namespace App\Domains\Tests\Repositories;

use App\Domains\Tests\Models\Category;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface extends RepositoryInterface
{

    public function firstOrCreate(string $name, ?int $parent_id): Category;

    /**
     * @param string|null $searchTerm
     * @param int $offset
     * @param int $resultCount number of results per page
     * @return array{data: Collection, count: int} Array contains paginated data and total count.
     */
    public function categoriesPaginated(?string $searchTerm, int $offset, int $resultCount): array;
}
