<?php

namespace App\Domains\Tests\Http\Controllers\Datatable;

use App\Domains\Tests\Services\InstructionService;
use App\Domains\Tests\Services\QuestionsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DatatableController extends Controller
{

    public function __construct(
        protected QuestionsService $questionsService,
        protected InstructionService $instructionService,
    ) {}


    /**
     * @param Request $request
     * @return JsonResponse //Datatable
     */
    public function questions(Request $request): JsonResponse
    {

        $columnIndex = $request['order'][0]['column']; // Column index
        $columnName = $request['columns'][$columnIndex]['name']; // Order Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc

        $filters = [];
        $filters['columnName'] = $columnName;
        $filters['columnSortOrder'] = $columnSortOrder;
        $filters['filterName'] = $request['filterName'];
        $filters['filterTest'] = $request['filterTest'];
        $filters['filterCategory'] = $request['filterCategory'];


        return $this->questionsService->dataTable($filters);
    }

    public function instructions(Request $request): JsonResponse
    {
        $filters = [];

        return $this->instructionService->dataTable($filters);
    }
}
