<?php

namespace App\Domains\Results\Repositories\Eloquent;

use App\Domains\Results\Models\Threshold;
use App\Domains\Results\Repositories\ThresholdRepositoryInterface;
use App\Domains\Results\Repositories\Eloquent\Models\Threshold as EloqThreshold;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;

class EloqThresholdRepository implements ThresholdRepositoryInterface
{

    public function __construct(
        private EloqThreshold $model
    )
    {}

    public function getById(string $id): ?CactusEntity
    {
        // TODO: Implement getById() method.
    }

    public function store(Threshold|CactusEntity $entity): Threshold
    {

        $threshold = $this->model->create([
            'interpretation' => $entity->getInterpretation(),
            'range_start' => $entity->getRangeStart(),
            'range_end' => $entity->getRangeEnd(),
            'test_id' => $entity->getTestId(),
            'subscale_id' => $entity->getSubscaleId(),
        ]);
       /* $threshold->interpretation = $entity->getInterpretation();
        $threshold->range_start = $entity->getRangeStart();
        $threshold->range_end = $entity->getRangeEnd();
        $threshold->test_id = $entity->getTestId();
        $threshold->subscale_id = $entity->getSubscaleId();
        $threshold->save();*/

        return ObjectSerializer::deserialize($threshold->toJson() ?? '{}', Threshold::class, 'json');
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
    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
    }

    public function findOrCreate(Threshold|CactusEntity $entity): Threshold
    {
        $threshold = $this->model
            ->where('test_id', $entity->getTestId())
            ->where('subscale_id', $entity->getSubscaleId())
            ->firstOrCreate([
                'interpretation' => $entity->getInterpretation(),
                'range_start' => $entity->getRangeStart(),
                'range_end' => $entity->getRangeEnd(),
                'test_id' => $entity->getTestId(),
                'subscale_id' => $entity->getSubscaleId(),
            ]);


        return ObjectSerializer::deserialize($threshold->toJson() ?? '{}', Threshold::class, 'json');
    }
}
