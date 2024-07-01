<?php

namespace App\Domains\Tests\Repositories;

use App\Domains\Tests\Models\Subscale;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;

interface SubscaleRepositoryInterface extends RepositoryInterface
{

    public function store(Subscale|CactusEntity $entity): ?Subscale;

    public function update(Subscale|CactusEntity $entity, string $id): ?Subscale;

    public function subscalesDatatable(array $filters = []): \Illuminate\Http\JsonResponse;

    public function findOrCreate(string $name, int $test_id): Subscale;
}
