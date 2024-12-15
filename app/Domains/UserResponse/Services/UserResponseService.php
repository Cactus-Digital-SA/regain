<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Services;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Scores\Services\UserScoreService;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesForm;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesQuestionForm;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesTextQuestionForm;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Support\Collection;

readonly class UserResponseService
{
    public function __construct(
        private UserScoreService $userScoreService,
        private UserQuestionnaireService $userQuestionnaireService,
    ) {
    }

    public function submitTextAnswer(SubmittedUserResponsesTextQuestionForm $questionForm, SubmittedUserResponsesForm $form): bool
    {
        $questionId = $questionForm->getQuestionId();

        /** @var Question $question */
        $question = Question::query()->find($questionId);

        $updatedId = UserResponse::query()
                                 ->upsert(
                                     [
                                         'user_id'     => $form->getUserId(),
                                         'for_user_id' => $form->getForUserId(),
                                         'question_id' => $questionForm->getQuestionId(),
                                         'text'        => $questionForm->getTextResponse(),
                                     ],
                                     ['user_id', 'question_id', 'for_user_id'],
                                     ['text']
                                 );

        return $updatedId > 0;
    }

    public function submitAnswers(SubmittedUserResponsesForm $form): bool
    {
        $status = true;
        foreach ($form->getQuestions() as $formQuestion) {
            $status = $this->submitAnswer($formQuestion, $form);
        }
        foreach ($form->getTextQuestions() as $formQuestion) {
            $status = $this->submitTextAnswer($formQuestion, $form);
        }

        return $status;
    }

    public function submitAnswer(SubmittedUserResponsesQuestionForm $questionForm, SubmittedUserResponsesForm $form): bool
    {
        $questionId = $questionForm->getQuestionId();

        /** @var Question $question */
        $question = Question::query()->find($questionId);

        /** @var Collection<mixed, QuestionResponse> $questionResponses */
        $questionResponses = QuestionResponse::query()
                                             ->where('question_id', '=', $questionId)
                                             ->whereIn('response_id', $questionForm->getResponseIds())
                                             ->get();
        $updatedIds        = [];

        foreach ($questionResponses as $questionResponse) {
            $updatedId = UserResponse::query()
                                     ->upsert(
                                         [
                                             'user_id'              => $form->getUserId(),
                                             'for_user_id'          => $form->getForUserId(),
                                             'question_id'          => $questionId,
                                             'subscale_id'          => $question->subscale_id,
                                             'question_response_id' => $questionResponse->id,
                                             'score'                => $questionResponse->score,
                                         ],
                                         ['user_id', 'question_id', 'subscale_id', 'question_response_id'],
                                         ['question_response_id', 'score']
                                     );

            if ($question->subscale_id > 0) {
                $this->userScoreService->calculateSubscaleScore($form->getUserId(), $question->subscale_id);
            }

            $this->userScoreService->calculateTestScore($form->getUserId(), $questionId);

            if ($updatedId > 0) {
                $updatedIds[] = $updatedId;
            }
        }

        return count($updatedIds) > 0;
    }

    public function userHasCompletedFlow(int $userId, QuestionnaireFlowType $type): bool
    {
        $userQuestions = $this->userQuestionnaireService->getForUserAndFlow($userId, $type);

        return false;
    }
}
