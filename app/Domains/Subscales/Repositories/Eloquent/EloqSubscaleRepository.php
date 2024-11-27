<?php

namespace App\Domains\Subscales\Repositories\Eloquent;

use App\Domains\Subscales\Models\Subscale;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale as EloquentSubscale;
use App\Domains\Subscales\Repositories\SubscaleRepositoryInterface;
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

    public function get(): ?array
    {
        $subscales =  $this->model->all();

        if($subscales){
            return ObjectSerializer::deserialize($subscales->toJson() ?? "{}", 'array<' . Subscale::class . '>', 'json');
        }
        return ObjectSerializer::deserialize("{}", 'array<' . Subscale::class . '>', 'json');
    }

    public function getById(string $id): ?Subscale
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

    public function findOrCreate(string $name, int $test_id, int $requiredQuestions, ?int $sort ): Subscale
    {
        $subscale = $this->model
            ->firstOrCreate([
                'name' => $name,
            ],
            [
                'test_id' => $test_id,
                'required_questions' => $requiredQuestions,
                'sort' => $sort
            ]);

        $subscale->load(['test','questions']);

        return ObjectSerializer::deserialize($subscale->toJson() ?? "{}", Subscale::class, 'json');
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, bool $withRelations = false): ?Subscale
    {
        $entity = $this->model->where('name', $name)->first();

        if($entity == null){
            return null;
        }

        if($withRelations){
            $entity->load([]);
        }

        return ObjectSerializer::deserialize($entity->toJson() ?? "{}", Subscale::class, 'json');
    }
}
