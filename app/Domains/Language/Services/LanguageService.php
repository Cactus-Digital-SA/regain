<?php

namespace App\Domains\Language\Services;

use App\Domains\Language\Models\Language;
use App\Domains\Language\Repositories\LanguageRepositoryInterface;

class LanguageService
{
    private LanguageRepositoryInterface $repository;

    /**
     * @param LanguageRepositoryInterface $repository
     */
    public function __construct(LanguageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $code
     * @return Language
     */
    public function getByCode(string $code = 'en'): Language
    {
        return $this->repository->getByCode($code);
    }

    /**
     * @return Language[]
     */
    public function get(): array
    {
        return $this->repository->get();
    }
}
