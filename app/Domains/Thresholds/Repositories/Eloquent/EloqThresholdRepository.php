<?php

namespace App\Domains\Thresholds\Repositories\Eloquent;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\QuestionnaireFlow\Models\QuestionnaireFlow;
use App\Domains\Tests\Repositories\Eloquent\Models\Test as EloqTest;
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

    public function getById(string $id): ?Threshold
    {
        $threshold = $this->model->where('id', $id)->first();
        $threshold->load('test', 'subscaleLimits', 'testLimits', 'test.subscales');

        return ObjectSerializer::deserialize($threshold->toJson() ?? '{}', Threshold::class, 'json');
    }

    public function addSubscaleLimits(Threshold $threshold, array $subscaleLimits): void
    {
        $eloqThreshold = EloqThreshold::find($threshold->getId());

        if (count($threshold->getSubscaleLimits()) > 0) {
            $eloquentModels = array_map(static function ($item) use ($threshold) {
                return ElogThresholdSubscaleLimit::firstOrCreate([
                    'threshold_id' => $threshold->getId(),
                    'subscale_id'  => $item->getSubscaleId(),
                    'low'          => $item->getlow(),
                    'high'         => $item->gethigh(),
                    'label'        => $item->getlabel(),
                    'notes'        => $item->getnotes(),
                ]);
            }, $threshold->getSubscaleLimits());

            $eloqThreshold->subscaleLimits()->saveMany($eloquentModels);
        }
    }

    public function store(Threshold|CactusEntity $entity): Threshold
    {
        $threshold = new EloqThreshold();

        $threshold->test_id        = $entity->gettestId();
        $threshold->question_start = $entity->getquestionStart();
        $threshold->question_end   = $entity->getquestionEnd();
        $threshold->display_type   = $entity->getdisplayType()->value;

        $threshold->save();

        $entity->setId($threshold->id);
        if (count($entity->getSubscaleLimits()) > 0) {
            $this->addSubscaleLimits($entity, $entity->getsubscaleLimits());
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

        $threshold->load('test', 'subscaleLimits', 'testLimits');

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
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        // TODO: Implement dataTable() method.
        throw new NotImplementedException();
    }

    public function findOrCreate(Threshold|CactusEntity $entity): Threshold
    {
        // TODO: Implement dataTable() method.
        throw new NotImplementedException();
    }

    /**
     * @param QuestionnaireFlowType $type
     * @return Threshold[]
     */
    public function getThresholdsByFlow(QuestionnaireFlowType $type): array
    {
        $eloqThresholds = $this->model
            ->whereIn('test_id', function ($query) use ($type) {
                $query->select('id')
                      ->from('tests')
                      ->whereIn('category_id', function ($subQuery) use ($type) {
                          $subQuery->select('category_id')
                                   ->from('questionnaire_flows')
                                   ->where('flow_type', $type);
                      });
            })
            ->get("id");

        $thresholds = [];
        foreach ($eloqThresholds as $eloqThreshold) {
            $thresholds[] = $this->getById($eloqThreshold->id);
        }

        return $thresholds;
    }

    public function getThresholdByTest(int $testId): ?Threshold
    {
        $eloqThreshold = $this->model->where('test_id', "=", $testId)->get("id")->first();

        return $eloqThreshold ?
            $this->getById($eloqThreshold->id) :
            null;
    }
}
