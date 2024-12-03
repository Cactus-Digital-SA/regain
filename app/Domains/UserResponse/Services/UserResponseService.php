<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Services;

use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Scores\Services\UserScoreService;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesForm;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponsesQuestionForm;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Support\Collection;

readonly class UserResponseService
{
    public function __construct(
        private UserScoreService $userScoreService,
    ) {
    }

    public function submitAnswer(SubmittedUserResponsesQuestionForm $form, int $userId): bool
    {
        $questionId = $form->getQuestionId();

        /** @var Question $question */
        $question = Question::query()->find($questionId);

        /** @var Collection<mixed, QuestionResponse> $questionResponses */
        $questionResponses = QuestionResponse::query()
                                             ->where('question_id', '=', $questionId)
                                             ->whereIn('response_id', $form->getResponseIds())
                                             ->get();

        $updatedIds = [];

        foreach ($questionResponses as $questionResponse) {
            $updatedId = UserResponse::query()
                                     ->upsert(
                                         [
                                             'user_id'              => $userId,
                                             'question_id'          => $questionId,
                                             'subscale_id'          => $question->subscale_id,
                                             'question_response_id' => $questionResponse->id,
                                             'score'                => $questionResponse->score,
                                         ],
                                         ['user_id', 'question_id', 'subscale_id', 'question_response_id'],
                                         ['question_response_id', 'score']
                                     );

            if ($question->subscale_id > 0) {
                $this->userScoreService->calculateSubscaleScore($userId, $question->subscale_id);
            }

            $this->userScoreService->calculateTestScore($userId, $questionId);

            if ($updatedId > 0) {
                $updatedIds[] = $updatedId;
            }
        }

        return count($updatedIds) > 0;
    }

    public function submitAnswers(SubmittedUserResponsesForm $form): bool
    {
        $status = true;
        foreach ($form->getQuestions() as $formQuestion) {
            $status = $this->submitAnswer($formQuestion, $form->getUserId());
        }

        return $status;
    }
}
