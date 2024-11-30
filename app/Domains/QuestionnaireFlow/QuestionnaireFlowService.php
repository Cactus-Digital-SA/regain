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
}
