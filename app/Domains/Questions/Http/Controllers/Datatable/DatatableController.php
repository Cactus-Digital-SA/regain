<?php

namespace App\Domains\Questions\Http\Controllers\Datatable;

use App\Domains\Instructions\Services\InstructionService;
use App\Domains\Questions\Services\QuestionsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatatableController extends Controller
{
    public function __construct(
        protected QuestionsService $questionsService,
        protected InstructionService $instructionService,
    ) {
    }

    /**
     * @param Request $request
     * @return JsonResponse //Datatable
     */
    public function questions(Request $request): JsonResponse
    {

        $columnIndex     = $request['order'][0]['column']; // Column index
        $columnName      = $request['columns'][$columnIndex]['name']; // Order Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc

        $filters                    = [];
        $filters['columnName']      = $columnName;
        $filters['columnSortOrder'] = $columnSortOrder;
        $filters['filterName']      = $request['filterName'];
        $filters['filterTest']      = $request['filterTest'];
        $filters['filterCategory']  = $request['filterCategory'];

        return $this->questionsService->dataTable(Auth::id(), $filters);
    }

    public function instructions(Request $request): JsonResponse
    {
        $filters = [];

        return $this->instructionService->dataTable(Auth::id(), $filters);
    }
}
