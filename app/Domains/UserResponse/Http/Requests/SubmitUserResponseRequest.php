<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Http\Requests;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponseForm;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubmitUserResponseRequest extends FormRequest
{
    private const QUESTION_ID           = 'questionId';
    private const QUESTION_RESPONSE_IDS = 'questionResponseIds';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check()) {
            /** @var User|null $user */
            $user = User::query()->find(Auth::id());

            return $user?->isPatient();
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            self::QUESTION_ID                 => 'required|integer',
            self::QUESTION_RESPONSE_IDS       => 'required|array',
            self::QUESTION_RESPONSE_IDS . '.*' => 'required|integer',
        ];
    }

    public function getQuestionId(): int
    {
        return (int)$this->input(self::QUESTION_ID);
    }

    /**
     * @return int[]
     */
    public function getQuestionResponseIds(): array
    {
        return collect($this->input(self::QUESTION_RESPONSE_IDS))
            ->map(fn ($id) => (int)$id)
            ->toArray();
    }

    public function getSubmittedUserResponseForm(): SubmittedUserResponseForm
    {
        return (new SubmittedUserResponseForm())
            ->setUserId((int)Auth::id())
            ->setQuestionId($this->getQuestionId())
            ->setQuestionResponseIds($this->getQuestionResponseIds());
    }
}
