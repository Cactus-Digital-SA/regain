<?php

namespace App\Domains\Questions\Repositories\Eloquent;

use App\Domains\Questions\Models\QuestionResponse;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse as EloqQuestionResponse;
use App\Domains\Questions\Repositories\QuestionResponseRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

class EloqQuestionResponseRepository implements QuestionResponseRepositoryInterface
{
    private EloqQuestionResponse $model;

    public function __construct(EloqQuestionResponse $questionResponse)
    {
        $this->model = $questionResponse;
    }

    public function getById(string $id): ?CactusEntity
    {
        $entity = $this->model::query()->find($id);

        return $entity
            ? ObjectSerializer::deserialize($entity->toJson() ?? "{}", QuestionResponse::class, 'json')
            : null;
    }

    public function store(QuestionResponse|CactusEntity $entity): QuestionResponse|CactusEntity|null
    {
        $newModel = $this->model->newQuery()->create([
            'question_id' => $entity->getQuestionId(),
            'response_id' => $entity->getResponseId(),
            'score'       => $entity->getScore(),
        ]);

        return $newModel
            ? ObjectSerializer::deserialize($newModel->toJson() ?? "{}", QuestionResponse::class, 'json')
            : null;
    }

    public function update(QuestionResponse|CactusEntity $entity, string $id): CactusEntity|QuestionResponse|null
    {
        $updated = $this->model
            ->newQuery()
            ->find($id)
            ?->update([
                'question_id' => $entity->getQuestionId(),
                'response_id' => $entity->getResponseId(),
                'score'       => $entity->getScore(),
            ]);

        return $updated
            ? ObjectSerializer::deserialize(
                $this->model
                    ->newQuery()
                    ->find($id)
                    ?->toJson() ?? "{}",
                QuestionResponse::class,
                'json'
            )
            : null;
    }

    public function deleteById(string $id): bool
    {
        return $this->model->newQuery()->find($id)?->delete();
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        throw new NotImplementedException();
    }
}
