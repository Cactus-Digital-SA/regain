<?php

namespace App\Domains\Tests\Repositories\Eloquent;

use App\Domains\Tests\Models\Reference;
use App\Domains\Tests\Models\Response;
use App\Domains\Tests\Repositories\Eloquent\Models\Reference as EloqReference;
use App\Domains\Tests\Repositories\ReferenceRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;

class EloqReferenceRepository implements ReferenceRepositoryInterface
{

    private EloqReference $model;

    public function __construct(EloqReference $model){
        $this->model = $model;
    }


    public function findOrCreate(string $title, string $type, string $group): Reference
    {
        $reference = $this->model
                    ->where('title', $title)
                    ->where('type', $type)
                    ->where('group', $group)
                    ->firstOrCreate([
                        'title' => $title,
                        'type' => $type,
                        'group' => $group
                    ]);

        return ObjectSerializer::deserialize($reference->toJson() ?? "{}", Reference::class , 'json');
    }

    public function getById(string $id): ?CactusEntity
    {
        // TODO: Implement getById() method.
    }

    public function store(CactusEntity $entity): ?CactusEntity
    {
        // TODO: Implement store() method.
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        // TODO: Implement update() method.
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
    }

    public function getByGroupAndType(string $group, string $type): array
    {
        //dd($type, $group);
        $reference = $this->model
            ->where('type', $type)
            ->where('group', $group)
            ->get();

        return ObjectSerializer::deserialize($reference->toJson() ?? "{}", 'array<' .Response::class . '>', 'json');

    }

    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
    }
}
