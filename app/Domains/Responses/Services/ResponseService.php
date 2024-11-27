<?php

namespace App\Domains\Responses\Services;

use App\Domains\Responses\Models\Response;
use App\Domains\Responses\Repositories\ResponseRepositoryInterface;

class ResponseService
{
    private ResponseRepositoryInterface $repository;

    /**
     * @param ResponseRepositoryInterface $repository
     */
    public function __construct(ResponseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @return Response[]
     */
    public function get():array
    {
        return $this->repository->get();
    }

    /**
     * @param string $id
     * @return Response|null
     */
    public function getById(string $id) : ?Response
    {
        return $this->repository->getById($id);
    }

    /**
     * @param string $type
     * @return Response[]|null
     */
    public function getByType(string $type) : ?array
    {
        return $this->repository->getByType($type);
    }

    /**
     * @param string $title
     * @return Response|null
     */
    public function getByTitle(string $title) : ?Response
    {
        return $this->repository->getByTitle($title);
    }

    /**
     * @param string $title
     * @param int $language_id
     * @param int $type
     * @param int|null $sort
     * @return Response
     */
    public function findOrCreate(string $title, int $language_id, int $type, ?int $sort): Response
    {
        return $this->repository->findOrCreate($title, $language_id,$type, $sort);
    }

    /**
     * @param Response $entity
     * @param string $questionId
     * @param string $score
     * @return Response
     */
    public function addScore(Response $entity, string $questionId, string $score): Response
    {
        return $this->repository->addScore($entity, $questionId , $score);
    }
}
