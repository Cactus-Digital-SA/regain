<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\User;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

/**
 * @template T of CactusEntity
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function getAuthUser(): ?User;

    public function getById(string $id): ?User;

    public function getByEmail(string $email): ?User;

    /**
     * @param string $roleId
     * @return User[]
     */
    public function getByRoleId(string $roleId ) : array;

    public function store(User|CactusEntity $entity): ?User;

    public function update(User|CactusEntity $entity, string $id, bool $updateRole = false): ?User;

    public function updatePassword(User|CactusEntity $entity, string $userId, mixed $expired): ?User;

    public function updateProfileImage(string $userId, UploadedFile $photo): ?User;

    public function deleteProfilePhoto(string $userId): bool;

    public function updateActive(string $userId, bool $active): bool;

    public function deleteById(string $id): bool;

    public function restore(string $userId): bool;

    public function destroyById(string $userId): bool;

    /**
     * @param string|null $searchTerm
     * @param int $offset
     * @param int $resultCount number of results per page
     * @return array{data: Collection, count: int} Array contains paginated data and total count.
     */
    public function emailsPaginated(?string $searchTerm, int $offset, int $resultCount): array;

    /**
     * @param array $filters
     * @return JsonResponse
     */
    public function usersDatatable(array $filters = []): JsonResponse;

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function apiAuthentication(User $user): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function apiLogOut(): JsonResponse;


    /**
     * @param string $code
     * @return bool
     */
    public function confirmTwoFactorAuth(string $code): bool;


}
