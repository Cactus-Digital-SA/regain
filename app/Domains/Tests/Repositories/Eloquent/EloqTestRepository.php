<?php

namespace App\Domains\Tests\Repositories\Eloquent;

use App\Domains\Tests\Models\Test;
use App\Domains\Tests\Repositories\Eloquent\Models\Test as EloqTest;
use App\Domains\Tests\Repositories\TestRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Nette\NotImplementedException;

class EloqTestRepository implements TestRepositoryInterface
{
    private EloqTest $model;

    public function __construct(EloqTest $model)
    {
        $this->model = $model;
    }

    public function getById(string $id): ?Test
    {
        // TODO: Implement getById() method.
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
        throw new NotImplementedException();
    }

    public function store(Test|CactusEntity $entity): ?Test
    {
        // TODO: Implement store() method.
        throw new NotImplementedException();
    }

    public function update(Test|CactusEntity $entity, string $id): ?Test
    {
        // TODO: Implement update() method.
        throw new NotImplementedException();
    }

    public function testsDatatable(array $filters = []): \Illuminate\Http\JsonResponse
    {
        // TODO: Implement testsDatatable() method.
        throw new NotImplementedException();
    }

    public function findOrCreate(string $name, int $category_id, ?int $sort): Test
    {
        $entity = $this->model
            ->firstOrCreate([
                'name' => $name,
            ],
                [
                    'category_id' => $category_id,
                    'sort'        => $sort
                ]);

        $entity->load(['category', 'questions']);

        return ObjectSerializer::deserialize($entity->toJson() ?? "{}", Test::class, 'json');
    }

    /**
     * @param string|null $searchTerm
     * @param int         $offset
     * @param int         $resultCount number of results per page
     * @return array{data: Collection, count: int} Array contains paginated data and total count.
     */
    public function testsPaginated(?string $searchTerm, int $offset, int $resultCount): array
    {
        $tests = $this->model->select('id', DB::raw('name AS text'));
        if ($searchTerm != null) {
            $tests = $tests->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $tests = $tests->skip($offset)->take($resultCount)->get('id');

        if ($searchTerm == null) {
            $count = $this->model->count();
        } else {
            $count = $tests->count();
        }

        return [
            "data"  => $tests,
            "count" => $count
        ];
    }

    public function get(): ?array
    {
        $tests = $this->model->all();

        if ($tests) {
            return ObjectSerializer::deserialize($tests->toJson() ?? "{}", 'array<' . Test::class . '>', 'json');
        }

        return ObjectSerializer::deserialize("{}", 'array<' . Test::class . '>', 'json');
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
        throw new NotImplementedException();
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, bool $withRelations = false): ?Test
    {
        $entity = $this->model->where('name', $name)->first();

        if ($entity == null) {
            return null;
        }

        if ($withRelations) {
            $entity->load(['category', 'questions', 'subscales', 'thresholds']);
        }

        return ObjectSerializer::deserialize($entity->toJson() ?? "{}", Test::class, 'json');
    }
}
