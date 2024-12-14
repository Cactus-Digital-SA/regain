<?php

namespace App\Domains\Language\Repositories\Eloquent;

use App\Domains\Language\Models\Language;
use App\Domains\Language\Repositories\Eloquent\Models\Language as EloqLanguage;
use App\Domains\Language\Repositories\LanguageRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

class EloqLanguageRepository implements LanguageRepositoryInterface
{
    private EloqLanguage $model;

    public function __construct(EloqLanguage $model)
    {
        $this->model = $model;
    }

    /**
     * @return Language[]|null
     */
    public function get(): ?array
    {
        $languages = $this->model->all();

        if ($languages) {
            return ObjectSerializer::deserialize($languages->toJson(), 'array<' . Language::class . '>', 'json');
        }

        return ObjectSerializer::deserialize("{}", 'array<' . Language::class . '>', 'json');
    }

    /**
     * @param string $code
     * @return Language|nullå
     */
    public function getByCode(string $code): ?Language
    {
        $language = $this->model->where('code', $code)->first();

        if ($language) {
            return ObjectSerializer::deserialize($language->toJson(), Language::class, 'json');
        }

        return ObjectSerializer::deserialize("{}", Language::class, 'json');
    }

    public function getById(string $id): ?CactusEntity
    {
        // TODO: Implement getById() method.
        throw new NotImplementedException();
    }

    public function store(CactusEntity $entity): ?CactusEntity
    {
        // TODO: Implement store() method.
        throw new NotImplementedException();
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        // TODO: Implement update() method.
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
        throw new NotImplementedException();
    }

    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
        throw new NotImplementedException();
    }
}
