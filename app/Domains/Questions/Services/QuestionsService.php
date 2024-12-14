<?php

namespace App\Domains\Questions\Services;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\Questions\Models\Question;
use App\Domains\Questions\Models\QuestionsPresenter;
use App\Domains\Questions\Repositories\Eloquent\Models\Question as EloquentQuestion;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Questions\Repositories\QuestionRepositoryInterface;
use App\Domains\UserQuestionnaire\Models\UserQuestionnaire;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use App\Domains\UserResponse\Services\UserResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

readonly class QuestionsService
{
    public function __construct(
        private QuestionRepositoryInterface $repository,
        private UserQuestionnaireService $userQuestionnaireService,
        private UserResponseService $userResponseService,
    ) {
    }

    /**
     * @param array $filters
     * @return JsonResponse
     */
    public function dataTable(array $filters = []): JsonResponse
    {
        return $this->repository->dataTable($filters);
    }

    /**
     * @param int $userId
     * @param int $take
     * @return QuestionsPresenter
     */
    public function fetchQuestionsAlt(int $userId, int $take = 1): QuestionsPresenter
    {
        $presenter = new QuestionsPresenter();

        $flow = $this->getFlowTypeForUser($userId);

        $presenter->setType($flow);

        $questionsPool  = $this->getQuestionIdsForPatient($userId, $flow);
        $activeQuestion = $this->getLatestAnsweredQuestion($userId);
        $questions      = [];

        $index = 0;
        if ($activeQuestion !== null) {
            $found = false;
            foreach ($questionsPool as $i => $value) {
                if ($value > $activeQuestion->getId()) {
                    $index = $i;
                    $found = true;
                    break;
                }
            }

            if (!$found && $questionsPool[count($questionsPool) - 1] === $activeQuestion->getId()) {
                // complete flow
                // this needs to be re-worked to take in account the edge case
                // that the last question is conditional, fine for now
                $this->userQuestionnaireService->setCompleted($userId, $flow, true);

                return $presenter->setQuestions([])->setCompleted(true);
            }
        }

        if ($take + $index > count($questionsPool)) {
            $take = (int)(count($questionsPool) - $index);
        }

        $questionsToAsk = array_slice($questionsPool, $index, $take);
        foreach ($questionsToAsk as $questionId) {
            $question = $this->getById($questionId);
            $this->populateHiddenData($question);
            $questions[] = $question;
        }

        return $presenter->setQuestions($questions)->setCompleted(false);
    }

    private function getFlowTypeForUser(int $userId): QuestionnaireFlowType
    {
        if (!$this->isReadyForSkillsTest($userId)) {
            return QuestionnaireFlowType::PRE_ASSESSMENT;
        }

        return QuestionnaireFlowType::SKILLS;
    }

    /**
     * @param int                   $userId
     * @param QuestionnaireFlowType $flow
     * @return int[]
     */
    private function getQuestionIdsForPatient(int $userId, QuestionnaireFlowType $flow): array
    {

        $questionIds = $this->userQuestionnaireService->getForUserAndFlow($userId, QuestionnaireFlowType::PRE_ASSESSMENT);
        if (count($questionIds) > 0) {
            return $questionIds;
        }

        $questions                = EloquentQuestion::whereIn('test_id', static function ($query) use ($flow) {
            $query->select('id')
                  ->from('tests')
                  ->whereIn('category_id', function ($subQuery) use ($flow) {
                      $subQuery->select('category_id')
                               ->from('questionnaire_flows')
                               ->where('flow_type', $flow->value);
                  });
        })->with(['subscale'])->orderBy("id")->get();
        $userQuestions            = [];
        $randomSubscalesProcessed = [];
        foreach ($questions as $question) {
            if ($question->subscale_id !== null && array_key_exists($question->subscale_id, $randomSubscalesProcessed)) {
                continue;
            }

            if (
                $question->subscale !== null &&
                $question->subscale->required_questions > 0
            ) {
                $subscaleQuestions = $question->subscale->questions;
                $requiredCount     = $question->subscale->required_questions;
                $randomQuestions   = $subscaleQuestions->shuffle()->take($requiredCount);
                $sortedQuestions   = $randomQuestions->sortBy('id');
                foreach ($sortedQuestions as $sortedQuestion) {
                    $userQuestions[] = $sortedQuestion->id;
                }
                $randomSubscalesProcessed[$question->subscale_id] = true;
            } else {
                $userQuestions[] = $question->id;
            }
        }

        $this->userQuestionnaireService->store(
            (new UserQuestionnaire())
                ->setUserId($userId)
                ->setQuestionnaireFlowType($flow)
                ->setQuestionIds($userQuestions)
        );

        return $userQuestions;
    }

    private function isReadyForSkillsTest(int $userId): bool
    {
        return $this->userResponseService->userHasCompletedFlow($userId, QuestionnaireFlowType::PRE_ASSESSMENT);
    }

    /**
     * @param Question $entity
     * @return Question|null
     */
    public function store(Question $entity): ?Question
    {
        return $this->repository->store($entity);
    }

    /**
     * @param Question    $entity
     * @param string|null $id
     * @return Question|null
     */
    public function storeWithId(Question $entity, ?string $id): ?Question
    {
        return $this->repository->storeWithId($entity, $id);
    }

    public function getLatestAnsweredQuestion(int $userId): ?Question
    {
        /** @var UserResponse|null $latestResponse */
        $latestResponse = UserResponse::query()
                                      ->where('user_id', $userId)
                                      ->orderBy('question_response_id', 'desc')
                                      ->first();

        if ($latestResponse !== null) {
            $activeQuestionId = $latestResponse->questionResponse->question->id;

            return $this->getById($activeQuestionId);
        }

        return null;
    }

    /**
     * @param int $id
     * @return Question|null
     */
    public function getById(int $id): ?Question
    {
        return $this->repository->getById($id);
    }

    private function populateHiddenData(?Question $question): ?Question
    {
        if ($question && count($question->getRequiredResponses()) > 0) {
            $requiredQuestionId       = $this->getRequiredQuestionId($question);
            $requiredQuestionResponse = $this->getResponseByQuestion($requiredQuestionId);
            $question->setRequiredQuestionId($requiredQuestionId);
            $questionResponseQuestionIds = array_map(static function ($userResponse) {
                return $userResponse->getId();
            }, $question->getRequiredResponses());
            $questionResponses           = QuestionResponse::query()
                                                           ->where('question_id', '=', $requiredQuestionId)
                                                           ->whereIn('id', $questionResponseQuestionIds)
                                                           ->get("response_id")->toArray();
            $responseIds                 = array_map(static function ($response) {
                return $response["response_id"];
            }, $questionResponses);
            $question->setRequiredQuestionResponses($responseIds);
            if ($requiredQuestionResponse && in_array($requiredQuestionResponse->question_response_id, $questionResponseQuestionIds, true)) {
                $question->setHiddenBecauseOfRequired(false);
            } else {
                $question->setHiddenBecauseOfRequired(true);
            }
        }

        return $question;
    }

    private function getRequiredQuestionId(Question $question): ?int
    {
        return EloquentQuestion::find($question->getId())?->requiredResponses()->first()?->question()->first()->id;
    }

    public function getResponseByQuestion(int $questionId): ?UserResponse
    {
        return UserResponse::where("question_id", "=", $questionId)
                           ->where("user_id", "=", Auth::user()->id)
                           ->first();
    }
}
