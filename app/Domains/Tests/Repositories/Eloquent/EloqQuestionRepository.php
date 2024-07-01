<?php

namespace App\Domains\Tests\Repositories\Eloquent;

use App\Domains\Tests\Models\Question;
use App\Domains\Tests\Repositories\Eloquent\Models\Question as EloqQuestion;
use App\Domains\Tests\Repositories\QuestionRepositoryInterface;
use App\Exceptions\GeneralException;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EloqQuestionRepository implements QuestionRepositoryInterface
{
    private EloqQuestion $model;
    public function __construct(EloqQuestion $question)
    {
        $this->model = $question;
    }

    public function get(): array
    {
        // TODO: Implement get() method.
    }

    /**
     * @throws GeneralException
     */
    public function store(Question|CactusEntity $entity): ?Question
    {

        //dd($entity);

        DB::beginTransaction();

        try {
            $question = new $this->model;
            //$question->id = $entity->getId();
            $question->test_id = $entity->getTestId();
            $question->instruction_id = $entity->getInstructionId();
            $question->subscale_id = $entity->getSubscaleId() ?? null;
            $question->save();

            $question->languages()->sync($entity->getLanguages(), false);
            $question->responses()->sync($entity->getResponses(), false);
            $question->references()->sync($entity->getReferences(), false);

            $question->load(['languages', 'responses.languages','subscale', 'instruction', 'test','references']);

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating instruction. Please try again.'));
        }

        DB::commit();

        return ObjectSerializer::deserialize($question->toJson() ?? "{}", Question::class, 'json');
        // TODO: Implement store() method.
    }

    public function update(Question|CactusEntity $entity, string $id): ?Question
    {
        // TODO: Implement update() method.
    }

    public function getById(string $id): ?Question
    {
       $question = EloqQuestion::find($id);

       if($question == null){
           return null;
       }
       return ObjectSerializer::deserialize($question->toJson() ?? "{}", Question::class, 'json');
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
    }

    /**
     * @param array $filters
     * @return JsonResponse
     * @throws Exception
     */
    public function dataTable(array $filters = []): JsonResponse
    {
        $questions = EloqQuestion::with(['languages', 'responses.languages', 'instruction', 'references' , 'test.category', 'subscale']);
        $questions = $questions->select('questions.*');


        $questions = $questions
            ->when($filters['filterTest'], function ($query,$searchTerm) {
                $query->whereHas('test',function ($q) use ($searchTerm){
                    $q->where('name' ,'LIKE', '%'.$searchTerm.'%');
                });
            })
            ->when($filters['filterName'], function ($query,$searchTerm) {
                $query->whereHas('languages',function ($q) use ($searchTerm){
                    $q->where('question' ,'LIKE', '%'.$searchTerm.'%');
                });
            })
            ->when($filters['filterCategory'], function ($query,$searchTerm) {
                $query->whereHas('test.category',function ($q) use($searchTerm){
                    $q->where('name' ,'LIKE', '%'.$searchTerm.'%');
                });
            });


        if ($filters['columnName'] && $filters['columnSortOrder']) {
            $questions = $questions->orderBy($filters['columnName'], $filters['columnSortOrder']);
        }

        $questions->orderBy('questions.id', 'asc');
        /**
        if(isset($filters['status']) && $filters['status'] == '1'){
            $questions = $questions->onlyTrashed();
        }


         * Custom Search - Filter in Datatables

        $users = $users
            ->when($filters['active'] !== null, function ($query,$searchTerm) use ($filters){
                $query->where('users.active', $filters['active']);
            })
            ->when($filters['filterName'], function ($query,$searchTerm) {
                $query->where('users.name', 'LIKE', '%'.$searchTerm.'%');
            })
            ->when($filters['filterUserEmail'], function ($query,$searchTerm) {
                $query->where('users.email', $searchTerm);
            })
            ->when($filters['filterRole'], function ($query,$searchTerm) {
                $query->whereHas('roles',function ($q2) use($searchTerm){
                    $q2->where('id' , $searchTerm);
                });
            });

        $users = $users->whereHas('roles',function ($q){
            $q->where('name' ,'!=', 'super-admin');
        })
            ->orWhereDoesntHave('roles');

        if ($filters['columnName'] && $filters['columnSortOrder']) {
            $users = $users->orderBy($filters['columnName'], $filters['columnSortOrder']);
        }

        $users = $users->orderBy('users.id','desc')
            ->groupBy('users.id');
        */
        return DataTables::of($questions)
            ->editColumn('languages', function(EloqQuestion $question) {
                $html="";
                foreach($question->languages as $language){
                    /*if($language->code == 'en') {
                        $html .= '<i class="fis fi fi-gb-eng rounded-circle me-2 fs-4"></i>';
                    }*/
                    $html .= $language->pivot->question;
                }
                return $html;
            })
            ->editColumn('responses', function(EloqQuestion $question) {
                $html="";
                foreach($question->responses as $response){
                    $html .= '<span class="badge rounded-pill bg-label-primary">';
                    $html .= $response->title;
                    $html .= '</span>';
                }
                return $html;
            })
            ->editColumn('references', function(EloqQuestion $question) {
                $html="";
                foreach($question->references as $reference){
                    $html .= '<button type="button" class="btn btn-primary btn-xs text-nowrap waves-effect waves-light" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="'. $reference->title .'" data-bs-original-title="'. $reference->type .'">';
                    $html .=  $reference->id;
                    $html .= '</button>';
                }
                return $html;
            })
            ->rawColumns(['languages','responses','tests','category', 'subscale','references'])
            ->toJson();

    }

    /**
     * @param Question|CactusEntity $entity
     * @return Question|null
     */
    public function attachReferences(Question|CactusEntity $entity): ?Question
    {
        $question = EloqQuestion::find($entity->getId());
        $question->references()->attach($entity->getReferences());

        $question->load(['references']);

        return ObjectSerializer::deserialize($question->toJson() ?? "{}", Question::class, 'json');
    }


    public function syncReferences(Question|CactusEntity $entity, int $id): ?Question
    {
        $question = EloqQuestion::find($id);
        $question->references()->sync($entity->getReferences());

        $question->load(['references']);

        return ObjectSerializer::deserialize($question->toJson() ?? "{}", Question::class, 'json');
    }

}
