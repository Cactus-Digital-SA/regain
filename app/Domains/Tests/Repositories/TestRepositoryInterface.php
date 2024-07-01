<?php

namespace App\Domains\Tests\Repositories;

use App\Domains\Tests\Models\Test;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

interface TestRepositoryInterface extends RepositoryInterface
{

    public function get():array;

    public function store(Test|CactusEntity $entity): ?Test;

    public function update(Test|CactusEntity $entity, string $id): ?Test;

    public function findOrCreate(string $name, int $category_id): Test;

    public function testsDatatable(array $filters = []): \Illuminate\Http\JsonResponse;

    /**
     * @param string|null $searchTerm
     * @param int $offset
     * @param int $resultCount number of results per page
     * @return array{data: Collection, count: int} Array contains paginated data and total count.
     */
    public function testsPaginated(?string $searchTerm, int $offset, int $resultCount): array;
}
