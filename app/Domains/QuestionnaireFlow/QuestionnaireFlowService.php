<?php

declare(strict_types=1);

namespace App\Domains\QuestionnaireFlow;

use App\Domains\Categories\Repositories\Eloquent\Models\Category;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use Illuminate\Support\Collection;

class QuestionnaireFlowService
{
    /**
     * @param QuestionnaireFlowType $type
     * @return Collection<mixed, Category>
     */
    public function getFlowCategories(QuestionnaireFlowType $type): Collection
    {
        $categoryIds = Category::query()
                               ->raw("SELECT category_id FROM questionnaire_flows WHERE flow_type = {$type->value}");

        return Category::query()
                       ->whereIn('id', $categoryIds)
                       ->get();
    }
}
