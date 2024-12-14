<?php

namespace App\Domains\Instructions\Services;

use App\Domains\Instructions\Models\Instruction;
use App\Domains\Instructions\Repositories\InstructionRepositoryInterface;
use Illuminate\Http\JsonResponse;

class InstructionService
{
    private InstructionRepositoryInterface $repository;

    /**
     * @param InstructionRepositoryInterface $repository
     */
    public function __construct(InstructionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Instruction[]
     */
    public function get(): array
    {
        return $this->repository->get();
    }

    public function store(Instruction $entity): ?Instruction
    {
        return $this->repository->store($entity);
    }

    /**
     * @param string $instruction
     * @param int    $language_id
     * @return Instruction|null
     */
    public function findOrCreateInstruction(string $instruction, int $language_id): ?Instruction
    {
        return $this->repository->findOrCreateInstruction($instruction, $language_id);
    }

    /**
     * @param array $filters
     * @return JsonResponse
     */
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        return $this->repository->dataTable($userId, $filters);
    }
}
