<?php

namespace App\Domains\Responses\Repositories\Eloquent;

use App\Domains\Responses\Models\Response;
use App\Domains\Responses\Repositories\Eloquent\Models\Response as EloquentResponse;
use App\Domains\Responses\Repositories\ResponseRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
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


    public function getById(string $id): ?Response
    {
        $entity = $this->model->find($id);

        if($entity == null){
            return null;
        }
        return ObjectSerializer::deserialize($entity->toJson() ?? "{}", Response::class, 'json');
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
    public function findOrCreate(string $title, int $language_id, int $type, ?int $sort): Response
    {
        $response = $this->model
            ->firstOrCreate([
                'title' => $title,
            ],
            [
                'type' => $type,
                'sort' => $sort
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

    public function addScore(Response $entity, string $questionId, string $score): Response
    {

        $response = $this->model
            ->where('id', $entity->getId())->first();
        $response->questions()->updateExistingPivot($questionId, ['score' => $score]);


        return ObjectSerializer::deserialize($response->toJson() ?? "{}", Response::class, 'json');
    }

    /**
     * @inheritDoc
     */
    public function getByType(string $type): ?array
    {
        $entity = $this->model->where('type', $type)->get();

        if($entity == null){
            return null;
        }

        return ObjectSerializer::deserialize($entity->toJson() ?? "{}", 'array<'.Response::class .'>', 'json');
    }

    /**
     * @inheritDoc
     */
    public function getByTitle(string $title): ?Response
    {
        $entity = $this->model->where('title', $title)->first();

        if($entity == null){
            return null;
        }

        return ObjectSerializer::deserialize($entity->toJson() ?? "{}", Response::class, 'json');

    }
}
