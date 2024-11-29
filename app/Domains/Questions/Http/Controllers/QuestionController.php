<?php

namespace App\Domains\Questions\Http\Controllers;

use App\Domains\Instructions\Services\InstructionService;
use App\Domains\Language\Services\LanguageService;
use App\Domains\Questions\Http\Requests\QuestionRequest;
use App\Domains\Questions\Models\Question;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\References\Services\ReferenceService;
use App\Domains\Responses\Enums\TypeEnum;
use App\Domains\Responses\Services\ResponseService;
use App\Domains\Subscales\Services\SubscaleService;
use App\Domains\Tests\Services\TestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
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
    ) {
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
        $languages    = $this->languageService->get();
        $tests        = $this->testService->get();
        $instructions = $this->instructionService->get();
        $subscales    = $this->subscaleService->get();
        $references   = $this->referenceService->get();
        $responses    = $this->responseService->get();

        $professions = $this->responseService->getByType(TypeEnum::PROFESSIONS->value);

        //dd($professions);

        return view('backend.content.questions.create', compact('references', 'professions', 'subscales', 'responses', 'instructions', 'languages', 'tests'));
    }

    /**
     * @param QuestionRequest $request
     * @return RedirectResponse
     */
    public function store(QuestionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated['questions'] as $lang => $question) {
            $questionDTO = new Question();

            $questionDTO->setTestId($validated['test_id']);
            $questionDTO->setSubscaleId($validated['subscale_id'] ?? null);
            $questionDTO->setInstructionId($validated['subscale_id'] ?? null);
            $questionDTO->setResponses($validated['responses']);
            $questionDTO->setReferences($validated['references'] ?? []);
            $questionDTO->setLanguages([$lang => ['question' => $question]]);

            $this->questionsService->store($questionDTO);
        }

        return redirect()->route('tests.questions.index')->with('success', 'Instruction created successfully');
    }
}
