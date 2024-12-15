<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Http\Requests;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesForm;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesQuestionForm;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesTextQuestionForm;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubmitMedicalHistoryResponsesRequest extends FormRequest
{
    private const DATA           = 'data';
    private const QUESTIONS      = 'questions';
    private const TEXT_QUESTIONS = 'textQuestions';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check()) {
            /** @var User|null $user */
            $user = User::query()->find(Auth::id());

            return $user?->isPractitioner();
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            self::DATA                                            => 'required|array',
            self::DATA . "." . self::QUESTIONS                    => 'nullable|array',
            self::DATA . "." . self::QUESTIONS . '.*.questionId'  => 'required|integer',
            self::DATA . "." . self::QUESTIONS . '.*.responses'   => 'required|array',
            self::DATA . "." . self::QUESTIONS . '.*.responses.*' => 'required|integer',

            self::DATA . "." . self::TEXT_QUESTIONS                   => 'nullable|array',
            self::DATA . "." . self::TEXT_QUESTIONS . '.*.questionId' => 'required|integer',
            self::DATA . "." . self::TEXT_QUESTIONS . '.*.response'   => 'required|string',
        ];
    }

    public function getSubmittedMedicalHistoryResponseForm(): SubmittedUserResponsesForm
    {
        // Create a SubmittedUserResponsesForm instance
        $form = new SubmittedUserResponsesForm();
        $form->setUserId((int)Auth::id());
        $form->setForUserId((int)$this->route('userId'));

        // Map each question with its responses and create SubmittedUserResponsesQuestionForm
        $questions = collect($this->getSubmittedQuestions())
            ->map(function ($item) {
                $questionForm = new SubmittedUserResponsesQuestionForm();
                $questionForm->setQuestionId($item['questionId']);
                $questionForm->setResponseIds($item['responses']); // These are integer responses

                return $questionForm;
            })
            ->toArray();

        // Map text questions
        $textQuestions = collect($this->getSubmittedTextQuestions())
            ->map(function ($item) {
                $questionForm = new SubmittedUserResponsesTextQuestionForm();
                $questionForm->setQuestionId($item['questionId']);
                $questionForm->setTextResponse($item['response']); // These are string responses

                return $questionForm;
            })
            ->toArray();

        // Set the questions and text questions to the form
        $form->setQuestions($questions);
        $form->setTextQuestions($textQuestions);

        return $form;
    }

    public function getSubmittedQuestions(): array
    {
        return collect($this->input(self::DATA . "." . self::QUESTIONS))
            ->map(function ($item) {
                return [
                    'questionId' => (int)$item['questionId'],
                    'responses'  => array_map('intval', $item['responses']), // Ensure responseIds are integers for questions
                ];
            })
            ->toArray();
    }

    public function getSubmittedTextQuestions(): array
    {
        return collect($this->input(self::DATA . "." . self::TEXT_QUESTIONS))
            ->map(function ($item) {
                return [
                    'questionId' => (int)$item['questionId'],
                    'response'   => $item['response']
                ];
            })
            ->toArray();
    }
}