<?php

namespace App\Domains\Responses\Repositories;

use App\Domains\Responses\Models\Response;
use App\Repositories\RepositoryInterface;

interface ResponseRepositoryInterface extends RepositoryInterface
{

    /**
     * @return Response[]|null
     */
    public function get(): ?array;

    /**
     * @param string $id
     * @return Response|null
     */
    public function getById(string $id): ?Response;

    /**
     * @param string $type
     * @return Response[]|null
     */
    public function getByType(string $type): ?array;

    /**
     * @param string $title
     * @return Response|null
     */
    public function getByTitle(string $title): ?Response;

    /**
     * @param string $title
     * @param int $language_id
     * @param int $type
     * @param int|null $sort
     * @return Response
     */
    public function findOrCreate(string $title, int $language_id, int $type, ?int $sort): Response;


    /**
     * @param Response $entity
     * @param string $questionId
     * @param string $score
     * @return Response
     */
    public function addScore(Response $entity, string $questionId, string $score): Response;
}
