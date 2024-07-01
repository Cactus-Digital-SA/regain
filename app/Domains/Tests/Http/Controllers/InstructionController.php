<?php

namespace App\Domains\Tests\Http\Controllers;

use App\Domains\Language\Services\LanguageService;
use App\Domains\Tests\Models\Instruction;
use App\Domains\Tests\Services\InstructionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstructionController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct(
        private InstructionService $instructionService,
        protected LanguageService $languageService,
    ) {}


    /**
     * @return View
     */
    public function index() : View{
        return view('backend.content.instructions.index');
    }


    public function create() : View {

        $languages = $this->languageService->get();

        return view('backend.content.instructions.create' ,compact('languages'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse {
        $validated =  $request->validate([
            'instructions' => 'required|array',
            'instructions.*' => 'required|string',
        ]);

        foreach ($validated['instructions'] as $lang => $instruction) {
            $this->instructionService->findOrCreateInstruction($instruction,$lang);
        }

        return redirect()->route('tests.instructions.index')->with('success' , 'Instruction created successfully');
    }

}
