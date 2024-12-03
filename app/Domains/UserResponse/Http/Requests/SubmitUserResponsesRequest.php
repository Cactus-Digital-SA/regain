<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Http\Requests;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponseForm;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesForm;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesQuestionForm;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubmitUserResponsesRequest extends FormRequest
{
    private const QUESTIONS = 'questions';

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
            self::QUESTIONS                    => 'required|array',
            self::QUESTIONS . '.*.questionId'  => 'required|integer',
            self::QUESTIONS . '.*.responses'   => 'required|array',
            self::QUESTIONS . '.*.responses.*' => 'required|integer',
        ];
    }

    /**
     * Get all submitted questions and responses.
     *
     * @return array
     */
    public function getSubmittedQuestions(): array
    {
        return collect($this->input(self::QUESTIONS))
            ->map(function ($item) {
                return [
                    'questionId' => (int)$item['questionId'],
                    'responses'  => array_map('intval', $item['responses']),  // Ensure responseIds are integers
                ];
            })
            ->toArray();
    }

    /**
     * Get the submitted UserResponseForm instance.
     *
     * @return SubmittedUserResponsesForm
     */
    public function getSubmittedUserResponseForms(): SubmittedUserResponsesForm
    {
        // Create a SubmittedUserResponsesForm instance
        $form = new SubmittedUserResponsesForm();
        $form->setUserId((int)Auth::id());

        // Map each question with its responses and create SubmittedUserResponsesQuestionForm
        $questions = collect($this->getSubmittedQuestions())
            ->map(function ($item) {
                $questionForm = new SubmittedUserResponsesQuestionForm();
                $questionForm->setQuestionId($item['questionId']);
                $questionForm->setResponseIds($item['responses']);

                return $questionForm;
            })
            ->toArray();

        // Set the questions to the form
        $form->setQuestions($questions);

        return $form;
    }
}