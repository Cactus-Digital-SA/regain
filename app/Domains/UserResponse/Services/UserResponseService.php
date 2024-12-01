<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Services;

use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\UserResponse\Http\Dtos\SubmittedUserResponseForm;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Support\Collection;

class UserResponseService
{
    public function submitAnswer(SubmittedUserResponseForm $form): bool
    {
        $questionId = $form->getQuestionId();

        /** @var Question $question */
        $question = Question::query()->find($questionId);

        /** @var Collection<mixed, QuestionResponse> $questionResponses */
        $questionResponses = QuestionResponse::query()
                                             ->where('question_id', '=', $questionId)
                                             ->whereIn('id', '=', $form->getQuestionResponseIds())
                                             ->get();

        $updatedIds = [];

        foreach ($questionResponses as $questionResponse) {
            $updatedId = UserResponse::query()
                        ->upsert(
                            [
                                'user_id'              => $form->getUserId(),
                                'subscale_id'          => $question->subscale_id,
                                'question_response_id' => $questionResponse->id,
                                'score'                => $questionResponse->score,
                            ],
                            ['user_id', 'subscale_id', 'question_response_id'],
                            ['question_response_id', 'score']
                        );

            if ($updatedId > 0) {
                $updatedIds[] = $updatedId;
            }
        }

        return count($updatedIds) > 0;
    }
}
