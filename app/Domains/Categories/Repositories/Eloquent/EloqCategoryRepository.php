<?php

namespace App\Domains\Categories\Repositories\Eloquent;

use App\Domains\Categories\Models\Category;
use App\Domains\Categories\Repositories\CategoryRepositoryInterface;
use App\Domains\Categories\Repositories\Eloquent\Models\Category as EloqCategory;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EloqCategoryRepository implements CategoryRepositoryInterface
{

    private EloqCategory $model;

    public function __construct(EloqCategory $model)
    {
        $this->model = $model;
    }

    public function firstOrCreate(string $name, ?int $parent_id, ?int $sort): Category
    {
        $category = $this->model
            ->firstOrCreate([
                'name' => $name,
            ],
                [
                'slug' => Str::slug($name),
                'parent_id' => $parent_id,
                'status' => true,
                'sort' => $sort
            ]);

        $category->load('parent');

        return ObjectSerializer::deserialize($category->toJson() ?? "{}", Category::class, 'json');
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
     * @param string|null $searchTerm
     * @param int $offset
     * @param int $resultCount number of results per page
     * @return array{data: Collection, count: int} Array contains paginated data and total count.
     */
    public function categoriesPaginated(?string $searchTerm, int $offset, int $resultCount): array
    {
        $categories = $this->model->select('id', DB::raw('name AS text'));
        if ($searchTerm != null) {
            $categories = $categories->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $categories = $categories->skip($offset)->take($resultCount)->get('id');


        if ($searchTerm == null) {
            $count = $this->model->count();
        } else {
            $count = $categories->count();
        }

        return array(
            "data" => $categories,
            "count" => $count
        );
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
    }
}
