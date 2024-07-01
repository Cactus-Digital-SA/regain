<?php

namespace App\Domains\Tests\Http\Controllers;

use App\Domains\Tests\Services\CategoryService;
use App\Domains\Tests\Services\TestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestApiController extends Controller
{

    protected TestService $testService;
    protected CategoryService $categoryService;

    public function __construct(TestService $testService,CategoryService $categoryService)
    {
        $this->testService = $testService;
        $this->categoryService = $categoryService;
    }

    public function testsPaginated(Request $request)  : JsonResponse {
        $validated = $request->validate([
            'page' => 'required|integer',
            'term' => 'nullable|string',
        ]);

        $page = $validated['page'];
        $resultCount = 25;

        $offset = ($page - 1) * $resultCount;

        /**
         * result['data']
         * result['count']
         */
        $result = $this->testService->testsPaginated($validated['term'], $offset, $resultCount);


        $subSections = $result['data'];
        $count = $result['count'];


        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;


        $results = array(
            "results" => $subSections,
            "pagination" => array(
                "more" => $morePages
            )
        );

        return response()->json($results);

    }

    public function categoriesPaginated(Request $request)  : JsonResponse {
        $validated = $request->validate([
            'page' => 'required|integer',
            'term' => 'nullable|string',
        ]);

        $page = $validated['page'];
        $resultCount = 25;

        $offset = ($page - 1) * $resultCount;

        /**
         * result['data']
         * result['count']
         */
        $result = $this->categoryService->categoriesPaginated($validated['term'], $offset, $resultCount);


        $subSections = $result['data'];
        $count = $result['count'];


        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;


        $results = array(
            "results" => $subSections,
            "pagination" => array(
                "more" => $morePages
            )
        );

        return response()->json($results);

    }
}
