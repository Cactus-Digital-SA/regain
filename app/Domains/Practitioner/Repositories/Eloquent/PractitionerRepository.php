<?php

namespace App\Domains\Practitioner\Repositories\Eloquent;

use App\Domains\Practitioner\Model\Practitioner;
use App\Domains\Practitioner\Repositories\Eloquent\Models\Practitioner as EloquentPractitioner;
use App\Domains\Practitioner\Repositories\PractitionerRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

class PractitionerRepository implements PractitionerRepositoryInterface
{
    public function getById(string $id): ?Practitioner
    {
        $practitionerData = EloquentPractitioner::with(['user', 'region'])->get();

        return ObjectSerializer::deserialize($practitionerData?->toJson() ?? "{}", Practitioner::class, 'json');
    }

    public function store(CactusEntity $entity): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        throw new NotImplementedException();
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        throw new NotImplementedException();
    }
}
