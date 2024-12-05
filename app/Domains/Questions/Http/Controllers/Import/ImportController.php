<?php

namespace App\Domains\Questions\Http\Controllers\Import;

use App\Domains\Questions\Import\MedicalHistoryQuestionsImport;
use App\Domains\Questions\Import\QuestionsImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function questions(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new QuestionsImport, $request->file('file'));

        return redirect()->back()->with('status', 'We successfully uploaded the data! The import will run in the background.');
    }

    public function medicalHistoryQuestions(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new MedicalHistoryQuestionsImport(), $request->file('file'));

        return redirect()->back()->with('status', 'We successfully uploaded the data! The import will run in the background.');
    }
}
