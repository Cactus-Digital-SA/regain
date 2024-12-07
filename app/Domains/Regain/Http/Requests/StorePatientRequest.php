<?php

namespace App\Domains\Regain\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'birthday' => ['required', 'date'],
//            'region_id' => ['required', 'exists:regions,id'],
            'post_code' => ['required', 'integer'],
            'primary_phone' => ['required', 'string'],
            'secondary_phone' => ['nullable', 'string'],
            'accessible_mobility' => ['nullable', 'in:true,false'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
