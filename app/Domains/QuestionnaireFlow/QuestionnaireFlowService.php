<?php

declare(strict_types = 1);

namespace App\Domains\QuestionnaireFlow;

use App\Domains\Categories\Repositories\Eloquent\Models\Category;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\QuestionnaireFlow\Models\QuestionnaireFlow;
use Illuminate\Support\Collection;

class QuestionnaireFlowService
{
    /**
     * @param QuestionnaireFlowType $type
     * @return Collection<mixed, Category>
     */
    public function getFlowCategories(QuestionnaireFlowType $type): Collection
    {
        $categoryIds = QuestionnaireFlow::query()
                                        ->where('flow_type', $type->value)
                                        ->pluck('category_id')
                                        ->toArray();

        return Category::query()
                       ->whereIn('id', $categoryIds)
                       ->get();
    }

    public function createFlowByCategory(int $categoryId): void
    {
        $flow = match ($categoryId) {
            1, 2    => QuestionnaireFlowType::PRE_ASSESSMENT,
            3       => QuestionnaireFlowType::SKILLS,
            4       => QuestionnaireFlowType::MEDICAL_HISTORY,
            default => null,
        };

        if ($flow === null) {
            return;
        }

        QuestionnaireFlow::createOrFirst([
            "flow_type"   => $flow->value,
            "category_id" => $categoryId
        ]);
    }
}
