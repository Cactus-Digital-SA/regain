<?php

declare(strict_types = 1);

namespace App\Domains\Scores\Services;

use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Scores\Repositories\Eloquent\UserSubscaleScore;
use App\Domains\Scores\Repositories\Eloquent\UserTestScore;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;

class UserScoreService
{
    public function calculateSubscaleScore(int $userId, int $subscaleId): int
    {
        $userResponsesScoreSum = UserResponse::query()
                                             ->where('user_id', '=', $userId)
                                             ->where('subscale_id', '=', $subscaleId)
                                             ->sum('score');

        $affectedModels = UserSubscaleScore::query()
                                           ->upsert(
                                               [
                                                   'user_id'     => $userId,
                                                   'subscale_id' => $subscaleId,
                                                   'score'       => $userResponsesScoreSum,
                                               ],
                                               ['user_id', 'subscale_id'],
                                               ['score']
                                           );

        return $affectedModels > 0
            ? (int)$userResponsesScoreSum
            : 0;
    }

    public function calculateTestScore(int $userId, int $questionId): int
    {
        $testId = Question::query()->find($questionId)->test_id;

        $questionIds = Question::query()
                               ->where('test_id', '=', $testId)
                               ->pluck('id')
                               ->toArray();

        $userResponsesScoreSum = UserResponse::query()
                                             ->whereIn('question_id', $questionIds)
                                             ->sum('score');

        $affectedModels = UserTestScore::query()
                                           ->upsert(
                                               [
                                                   'user_id'     => $userId,
                                                   'test_id'     => $testId,
                                                   'score'       => $userResponsesScoreSum,
                                               ],
                                               ['user_id', 'test_id'],
                                               ['score']
                                           );

        return $affectedModels > 0
            ? (int)$userResponsesScoreSum
            : 0;
    }
}
