<?php

namespace App\Domains\Instructions\Repositories\Eloquent;

use App\Domains\Instructions\Models\Instruction;
use App\Domains\Instructions\Repositories\Eloquent\Models\Instruction as EloqInstruction;
use App\Domains\Instructions\Repositories\InstructionRepositoryInterface;
use App\Exceptions\GeneralException;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Nette\NotImplementedException;
use Yajra\DataTables\Facades\DataTables;

class EloqInstructionRepository implements InstructionRepositoryInterface
{
    private EloqInstruction $model;

    public function __construct(EloqInstruction $instruction)
    {
        $this->model = $instruction;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        $instructions = $this->model->all();

        return ObjectSerializer::deserialize($instructions->toJson() ?? "{}", 'array<' . \App\Domains\Instructions\Models\Instruction::class . '>', 'json');
    }

    public function getById(string $id): ?CactusEntity
    {
        $instructions = $this->model->find($id);

        return ObjectSerializer::deserialize($instructions->toJson() ?? "{}", \App\Domains\Instructions\Models\Instruction::class, 'json');
    }

    /**
     * @param \App\Domains\Instructions\Models\Instruction|CactusEntity $entity
     * @return \App\Domains\Instructions\Models\Instruction|null
     * @throws GeneralException
     */
    public function store(\App\Domains\Instructions\Models\Instruction|CactusEntity $entity): ?\App\Domains\Instructions\Models\Instruction
    {
        DB::beginTransaction();

        try {
            $instruction              = new $this->model;
            $instruction->content     = $entity->getContent() ?? null;
            $instruction->language_id = $entity->getLanguageId() ?? null;

            $instruction->save();
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating instruction. Please try again.'));
        }

        DB::commit();

        return ObjectSerializer::deserialize($instruction->toJson() ?? "{}", \App\Domains\Instructions\Models\Instruction::class, 'json');
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        // TODO: Implement update() method.
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
        throw new NotImplementedException();
    }

    public function getInstructionByTest(string $testId): array
    {
        // TODO: Implement getInstructionByTest() method.
        throw new NotImplementedException();
    }

    /**
     * @param string $instruction
     * @param int    $language_id
     * @return Instruction|null
     */
    public function findOrCreateInstruction(string $instruction, int $language_id): ?Instruction
    {
        $instruction = $this->model
            ->where('language_id', $language_id)
            ->where('content', $instruction)
            ->firstOrCreate([
                'language_id' => $language_id,
                'content'     => $instruction
            ]);

        $instruction->load('language');

        return ObjectSerializer::deserialize($instruction->toJson() ?? "{}", Instruction::class, 'json');
    }

    /**
     * @param array $filters
     * @return JsonResponse
     * @throws Exception
     */
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        $instructions = $this->model->with(['language', 'questions']);
        $instructions = $instructions->select('instructions.*');

        $instructions->orderBy('instructions.id', 'asc');

        return DataTables::of($instructions)
                         ->toJson();
    }
}
