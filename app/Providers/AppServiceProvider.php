<?php

namespace App\Providers;

use App\Domains\Auth\Repositories\Eloquent\EloqPermissionRepository;
use App\Domains\Auth\Repositories\Eloquent\EloqRoleRepository;
use App\Domains\Auth\Repositories\Eloquent\EloqUserRepository;
use App\Domains\Auth\Repositories\PermissionRepositoryInterface;
use App\Domains\Auth\Repositories\RoleRepositoryInterface;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Categories\Repositories\CategoryRepositoryInterface;
use App\Domains\Categories\Repositories\Eloquent\EloqCategoryRepository;
use App\Domains\Instructions\Repositories\Eloquent\EloqInstructionRepository;
use App\Domains\Instructions\Repositories\InstructionRepositoryInterface;
use App\Domains\Language\Repositories\Eloquent\EloqLanguageRepository;
use App\Domains\Language\Repositories\LanguageRepositoryInterface;
use App\Domains\Questions\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Questions\Repositories\QuestionRepositoryInterface;
use App\Domains\References\Repositories\Eloquent\EloqReferenceRepository;
use App\Domains\References\Repositories\ReferenceRepositoryInterface;
use App\Domains\Responses\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Responses\Repositories\ResponseRepositoryInterface;
use App\Domains\Subscales\Repositories\Eloquent\EloqSubscaleRepository;
use App\Domains\Subscales\Repositories\SubscaleRepositoryInterface;
use App\Domains\Tests\Repositories\Eloquent\EloqTestRepository;
use App\Domains\Tests\Repositories\TestRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloqUserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, EloqRoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, EloqPermissionRepository::class);

        //Tests
        $this->app->bind(InstructionRepositoryInterface::class, EloqInstructionRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, EloqQuestionRepository::class);
        $this->app->bind(TestRepositoryInterface::class, EloqTestRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, EloqLanguageRepository::class);
        $this->app->bind(SubscaleRepositoryInterface::class, EloqSubscaleRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, EloqCategoryRepository::class);
        $this->app->bind(ReferenceRepositoryInterface::class, EloqReferenceRepository::class);
        $this->app->bind(ResponseRepositoryInterface::class, EloqResponseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
