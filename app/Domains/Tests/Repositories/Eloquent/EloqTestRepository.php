<?php

namespace App\Domains\Tests\Repositories\Eloquent;

use App\Domains\Tests\Models\Test;
use App\Domains\Tests\Repositories\TestRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use App\Domains\Tests\Repositories\Eloquent\Models\Test as EloqTest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloqTestRepository implements TestRepositoryInterface
{
    private EloqTest $model;
    public function __construct(EloqTest $model){
        $this->model = $model;
    }

    public function getById(string $id): ?CactusEntity
    {
        // TODO: Implement getById() method.
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
    }

    public function get(): ?array
    {
        $tests =  $this->model->all();

        if($tests){
            return ObjectSerializer::deserialize($tests->toJson() ?? "{}", 'array<' . Test::class . '>', 'json');
        }
        return ObjectSerializer::deserialize("{}", 'array<' . Test::class . '>', 'json');
    }

    public function store(Test|CactusEntity $entity): ?Test
    {
        // TODO: Implement store() method.
    }

    public function update(Test|CactusEntity $entity, string $id): ?Test
    {
        // TODO: Implement update() method.
    }

    public function testsDatatable(array $filters = []): \Illuminate\Http\JsonResponse
    {
        // TODO: Implement testsDatatable() method.
    }


    /**
     * @param string $name
     * @param int $category_id
     * @return Test
     */
    public function findOrCreate(string $name, int $category_id): Test
    {
        $category = $this->model
            ->where('name', $name)
            ->firstOrCreate([
                'name' => $name,
                'category_id' => $category_id,
            ]);

        $category->load(['category','questions']);

        return ObjectSerializer::deserialize($category->toJson() ?? "{}", Test::class, 'json');
    }

    /**
     * @param string|null $searchTerm
     * @param int $offset
     * @param int $resultCount number of results per page
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

        return array(
            "data" => $tests,
            "count" => $count
        );
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
    }
}
