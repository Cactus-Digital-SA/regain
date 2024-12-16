<?php

namespace App\Domains\Region\Repositories\Eloquent;

use App\Domains\References\Models\Reference;
use App\Domains\Region\Repositories\Eloquent\Models\Region as EloqRegion;
use App\Domains\Region\Models\Region;
use App\Domains\Region\Repositories\RegionRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

class RegionRepository implements RegionRepositoryInterface
{
    private $model;

    public function __construct(EloqRegion $model)
    {
        $this->model = $model;
    }

    /**
     * @return Region[]
     */
    public function get(): array
    {
        $reference = $this->model->get();

        return ObjectSerializer::deserialize($reference->toJson() ?? "{}", "array<" . Region::class . ">", 'json');
    }

    public function getById(string $id): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function store(CactusEntity $entity): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        throw new NotImplementedException();
    }

    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        throw new NotImplementedException();
    }
}
