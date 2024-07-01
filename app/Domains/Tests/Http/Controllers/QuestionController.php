<?php

namespace App\Domains\Tests\Http\Controllers;

use App\Domains\Language\Services\LanguageService;
use App\Domains\Tests\Models\Question;
use App\Domains\Tests\Services\InstructionService;
use App\Domains\Tests\Services\QuestionsService;
use App\Domains\Tests\Services\ReferenceService;
use App\Domains\Tests\Services\ResponseService;
use App\Domains\Tests\Services\SubscaleService;
use App\Domains\Tests\Services\TestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected QuestionsService $questionsService,
        protected LanguageService $languageService,
        protected TestService $testService,
        protected InstructionService $instructionService,
        protected SubscaleService $subscaleService,
        protected ReferenceService $referenceService,
        protected ResponseService $responseService,
    )
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('backend.content.questions.index');
    }


    /**
     * @return View
     */
    public function create(): View
    {
        $languages = $this->languageService->get();
        $tests = $this->testService->get();
        $instructions = $this->instructionService->get();
        $subscales = $this->subscaleService->get();
        $references = $this->referenceService->get();
        $responses = $this->responseService->get();

        return view('backend.content.questions.create' ,compact('references','subscales','responses','instructions','languages','tests'));
    }

    public function store(Request $request)
    {
        $validated =  $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'required|integer',
            'references' => 'required|array',
            'references.*' => 'required|integer',
            'questions' => 'required|array',
            'questions.*' => 'required|string',
            'test_id' => 'required|integer',
            'subscale_id' => 'nullable|integer',
            'instruction_id' => 'nullable|integer',
        ]);

        foreach ($validated['questions'] as $lang => $question) {
            $questionDTO = new Question();

            $questionDTO->setTestId($validated['test_id']);
            $questionDTO->setSubscaleId($validated['subscale_id'] ?? null);
            $questionDTO->setInstructionId($validated['subscale_id'] ?? null);
            $questionDTO->setResponses($validated['responses']);
            $questionDTO->setReferences($validated['references']);
            $questionDTO->setLanguages([$lang => ['question' => $question]]);

            $this->questionsService->store($questionDTO);
        }

        return redirect()->route('tests.questions.index')->with('success' , 'Instruction created successfully');

    }
}
