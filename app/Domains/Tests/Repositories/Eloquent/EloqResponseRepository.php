<?php

namespace App\Domains\Tests\Repositories\Eloquent;

use App\Domains\Tests\Models\Response;
use App\Domains\Tests\Models\Test;
use App\Domains\Tests\Repositories\ResponseRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use App\Domains\Tests\Repositories\Eloquent\Models\Response as EloquentResponse;
use Illuminate\Http\JsonResponse;

class EloqResponseRepository implements ResponseRepositoryInterface
{

    private EloquentResponse $model;

    public function __construct(EloquentResponse $model)
    {
        $this->model = $model;
    }


    public function get(): ?array
    {
        $responses =  $this->model->all();

        if($responses){
            return ObjectSerializer::deserialize($responses->toJson() ?? "{}", 'array<' . Response::class . '>', 'json');
        }
        return ObjectSerializer::deserialize("{}", 'array<' . Response::class . '>', 'json');
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

    /**
     * @inheritDoc
     */
    public function findOrCreate(string $title, int $language_id): Response
    {
        $response = $this->model
            ->where('title', $title)
            ->firstOrCreate([
                'title' => $title,
            ]);

        $response->languages()->sync([$language_id, ['question' => $title]],false);
        //$response->questions()->attach($question_id);

        $response->load(['languages','questions']);

        return ObjectSerializer::deserialize($response->toJson() ?? "{}", Response::class, 'json');
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
    }
}
