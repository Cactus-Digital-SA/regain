<?php

namespace App\Domains\Instructions\Repositories;

use App\Domains\Instructions\Models\Instruction;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;

interface InstructionRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Instruction[]
     */
    public function get(): array;

    /**
     * @param string $testId
     * @return Instruction[]
     */
    public function getInstructionByTest(string $testId): array;

    /**
     * @param Instruction|CactusEntity $entity
     * @return Instruction|null
     */
    public function store(Instruction|CactusEntity $entity): ?Instruction;

    /**
     * @param string $instruction
     * @param int    $language_id
     * @return Instruction|null
     */
    public function findOrCreateInstruction(string $instruction, int $language_id): ?Instruction;
}
