<?php

namespace App\Domains\Thresholds\Repositories\Eloquent;

use App\Domains\Thresholds\Models\Threshold;
use App\Domains\Thresholds\Repositories\Eloquent\Models\ThresholdSubscaleLimit as ElogThresholdSubscaleLimit;
use App\Domains\Thresholds\Repositories\Eloquent\Models\ThresholdTestLimit as ElogThresholdTestLimit;
use App\Domains\Thresholds\Repositories\Eloquent\Models\Threshold as EloqThreshold;
use App\Domains\Thresholds\Repositories\ThresholdRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

class EloqThresholdRepository implements ThresholdRepositoryInterface
{
    public function __construct(
        private EloqThreshold $model
    ) {
    }

    public function getById(string $id): ?CactusEntity
    {
        // TODO: Implement getById() method.
        throw new NotImplementedException();
    }

    public function store(Threshold|CactusEntity $entity): Threshold
    {
        $threshold = new EloqThreshold();

        $threshold->test_id        = $entity->gettestId();
        $threshold->subscale_id    = $entity->getsubscaleId();
        $threshold->question_start = $entity->getquestionStart();
        $threshold->question_end   = $entity->getquestionEnd();
        $threshold->display_type   = $entity->getdisplayType()->value;

        $threshold->save();

        if (count($entity->getSubscaleLimits()) > 0) {
            $eloquentModels = array_map(static function ($item) use ($threshold) {
                return ElogThresholdSubscaleLimit::firstOrCreate([
                    'threshold_id' => $threshold->id,
                    'low'          => $item->getlow(),
                    'high'         => $item->gethigh(),
                    'label'        => $item->getlabel(),
                    'notes'        => $item->getnotes(),
                ]);
            }, $entity->getSubscaleLimits());

            $threshold->subscaleLimits()->saveMany($eloquentModels);
        }

        if (count($entity->getTestLimits()) > 0) {
            $eloquentModels = array_map(static function ($item) use ($threshold) {
                return ElogThresholdTestLimit::firstOrCreate([
                    'threshold_id' => $threshold->id,
                    'low'          => $item->getlow(),
                    'high'         => $item->gethigh(),
                    'label'        => $item->getlabel(),
                    'notes'        => $item->getnotes(),
                ]);
            }, $entity->getTestLimits());

            $threshold->testLimits()->saveMany($eloquentModels);
        }

        $threshold->load('subscale', 'test', 'subscaleLimits', 'testLimits');

        return ObjectSerializer::deserialize($threshold->toJson() ?? '{}', Threshold::class, 'json');
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

    /**
     * @inheritDoc
     */
    public function dataTable(array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
        throw new NotImplementedException();
    }

    public function findOrCreate(Threshold|CactusEntity $entity): Threshold
    {
        $threshold = $this->model
            ->where('test_id', $entity->getTestId())
            ->where('subscale_id', $entity->getSubscaleId())
            ->firstOrCreate([
                'interpretation' => $entity->getInterpretation(),
                'range_start'    => $entity->getRangeStart(),
                'range_end'      => $entity->getRangeEnd(),
                'test_id'        => $entity->getTestId(),
                'subscale_id'    => $entity->getSubscaleId(),
            ]);

        return ObjectSerializer::deserialize($threshold->toJson() ?? '{}', Threshold::class, 'json');
    }
}
