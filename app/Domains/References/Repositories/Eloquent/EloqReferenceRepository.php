<?php

namespace App\Domains\References\Repositories\Eloquent;

use App\Domains\References\Models\Reference;
use App\Domains\References\Repositories\Eloquent\Models\Reference as EloqReference;
use App\Domains\References\Repositories\ReferenceRepositoryInterface;
use App\Domains\Responses\Models\Response;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;

class EloqReferenceRepository implements ReferenceRepositoryInterface
{

    private EloqReference $model;

    public function __construct(EloqReference $model){
        $this->model = $model;
    }

    public function get(): ?array
    {
        $data =  $this->model->all();

        if($data){
            return ObjectSerializer::deserialize($data->toJson() ?? "{}", 'array<' . Reference::class . '>', 'json');
        }
        return ObjectSerializer::deserialize("{}", 'array<' . Reference::class . '>', 'json');
    }

    public function findOrCreate(string $title, string $type, string $group, ?string $link, ?string $groupName): Reference
    {
        $reference = $this->model->firstOrCreate([
                        'title' => $title,
                        'type' => $type,
                        'group' => $group
                        ],
                        [
                            'group_name' => $groupName,
                            'link' => $link
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
