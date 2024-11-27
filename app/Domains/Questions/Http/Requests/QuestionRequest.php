<?php

namespace App\Domains\Questions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{


    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('admin.tests.create');
    }

    public function rules(): array
    {
        return [
            'responses' => 'required|array',
            'responses.*' => 'required|integer',
            'references' => 'array',
            'references.*' => 'nullable|integer',
            'questions' => 'required|array',
            'questions.*' => 'required|string',
            'test_id' => 'required|integer',
            'subscale_id' => 'nullable|integer',
            'instruction_id' => 'nullable|integer',
        ];
    }
}
