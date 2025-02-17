<?php

namespace App\Domains\Subscales\Repositories\Eloquent;

use App\Domains\Subscales\Models\Subscale;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale as EloquentSubscale;
use App\Domains\Subscales\Repositories\SubscaleRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

class EloqSubscaleRepository implements SubscaleRepositoryInterface
{
    private EloquentSubscale $model;

    public function __construct(EloquentSubscale $subscale)
    {
        $this->model = $subscale;
    }

    public function get(): ?array
    {
        $subscales = $this->model->all();

        if ($subscales) {
            return ObjectSerializer::deserialize($subscales->toJson() ?? "{}", 'array<' . Subscale::class . '>', 'json');
        }

        return ObjectSerializer::deserialize("{}", 'array<' . Subscale::class . '>', 'json');
    }

    public function getById(string $id): ?Subscale
    {
        // TODO: Implement getById() method.
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
        throw new NotImplementedException();
    }

    public function store(Subscale|CactusEntity $entity): ?Subscale
    {
        // TODO: Implement store() method.
        throw new NotImplementedException();
    }

    public function update(Subscale|CactusEntity $entity, string $id): ?Subscale
    {
        // TODO: Implement update() method.
        throw new NotImplementedException();
    }

    public function subscalesDatatable(array $filters = []): JsonResponse
    {
        // TODO: Implement subscalesDatatable() method.
        throw new NotImplementedException();
    }

    private function getRequiredQuestions(int $testId): ?int
    {
        // TODO: required_questions needs a better solution
        return match ($testId) {
            12      => 5,
            16      => 4,
            17, 18  => 2,
            20, 21  => 3,
            default => null
        };
    }

    public function findOrCreate(string $name, int $test_id, int $requiredQuestions, ?int $sort): Subscale
    {
        $subscale = $this->model
            ->firstOrCreate([
                'name'    => $name,
                'test_id' => $test_id,
            ],
                [
                    'test_id'            => $test_id,
                    'required_questions' => $this->getRequiredQuestions($test_id),
                    'sort'               => $sort
                ]);

        $subscale->load(['test', 'questions']);

        return ObjectSerializer::deserialize($subscale->toJson() ?? "{}", Subscale::class, 'json');
    }

    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
        throw new NotImplementedException();
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, bool $withRelations = false): ?Subscale
    {
        $entity = $this->model->where('name', $name)->first();

        if ($entity == null) {
            return null;
        }

        if ($withRelations) {
            $entity->load([]);
        }

        return ObjectSerializer::deserialize($entity->toJson() ?? "{}", Subscale::class, 'json');
    }

    public function findByNameAndTest(string $name, int $testId, bool $withRelations = false): ?Subscale
    {
        $entity = $this->model->where(['name' => $name, "test_id" => $testId])->first();

        if ($entity == null) {
            return null;
        }

        if ($withRelations) {
            $entity->load([]);
        }

        return ObjectSerializer::deserialize($entity->toJson() ?? "{}", Subscale::class, 'json');
    }
}
