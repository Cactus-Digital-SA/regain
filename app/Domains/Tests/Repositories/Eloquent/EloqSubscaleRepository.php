<?php

namespace App\Domains\Tests\Repositories\Eloquent;

use App\Domains\Tests\Repositories\Eloquent\Models\Subscale as EloquentSubscale;
use App\Domains\Tests\Models\Subscale;
use App\Domains\Tests\Repositories\SubscaleRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;

class EloqSubscaleRepository implements SubscaleRepositoryInterface
{

    private EloquentSubscale $model;
    public function __construct(EloquentSubscale $subscale)
    {
        $this->model = $subscale;
    }

    public function getById(string $id): ?CactusEntity
    {
        // TODO: Implement getById() method.
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
    }

    public function store(Subscale|CactusEntity $entity): ?Subscale
    {
        // TODO: Implement store() method.
    }

    public function update(Subscale|CactusEntity $entity, string $id): ?Subscale
    {
        // TODO: Implement update() method.
    }

    public function subscalesDatatable(array $filters = []): \Illuminate\Http\JsonResponse
    {
        // TODO: Implement subscalesDatatable() method.
    }

    /**
     * @param string $name
     * @param int $test_id
     * @return Subscale
     */
    public function findOrCreate(string $name, int $test_id): Subscale
    {
        $subscale = $this->model
            ->where('name', $name)
            ->firstOrCreate([
                'name' => $name,
                'test_id' => $test_id,
            ]);

        $subscale->load(['test','questions']);

        return ObjectSerializer::deserialize($subscale->toJson() ?? "{}", Subscale::class, 'json');
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
    }
}
