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
use App\Domains\Patient\Repositories\Eloquent\EloqPatientDataRepository;
use App\Domains\Patient\Repositories\PatientDataRepositoryInterface;
use App\Domains\Practitioner\Repositories\Eloquent\PractitionerRepository;
use App\Domains\Practitioner\Repositories\PractitionerRepositoryInterface;
use App\Domains\Questions\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Questions\Repositories\Eloquent\EloqQuestionResponseRepository;
use App\Domains\Questions\Repositories\QuestionRepositoryInterface;
use App\Domains\Questions\Repositories\QuestionResponseRepositoryInterface;
use App\Domains\References\Repositories\Eloquent\EloqReferenceRepository;
use App\Domains\References\Repositories\ReferenceRepositoryInterface;
use App\Domains\Responses\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Responses\Repositories\ResponseRepositoryInterface;
use App\Domains\Subscales\Repositories\Eloquent\EloqSubscaleRepository;
use App\Domains\Subscales\Repositories\SubscaleRepositoryInterface;
use App\Domains\Tests\Repositories\Eloquent\EloqTestRepository;
use App\Domains\Tests\Repositories\TestRepositoryInterface;
use App\Domains\Thresholds\Repositories\Eloquent\EloqThresholdRepository;
use App\Domains\Thresholds\Repositories\ThresholdRepositoryInterface;
use App\Domains\UserQuestionnaire\Repositories\Eloquent\UserQuestionnaireRepository;
use App\Domains\UserQuestionnaire\Repositories\UserQuestionnaireRepositoryInterface;
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
        $this->app->singleton(InstructionRepositoryInterface::class, EloqInstructionRepository::class);
        $this->app->singleton(QuestionRepositoryInterface::class, EloqQuestionRepository::class);
        $this->app->singleton(TestRepositoryInterface::class, EloqTestRepository::class);
        $this->app->singleton(LanguageRepositoryInterface::class, EloqLanguageRepository::class);
        $this->app->singleton(SubscaleRepositoryInterface::class, EloqSubscaleRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, EloqCategoryRepository::class);
        $this->app->singleton(ReferenceRepositoryInterface::class, EloqReferenceRepository::class);
        $this->app->singleton(ResponseRepositoryInterface::class, EloqResponseRepository::class);
        $this->app->singleton(PatientDataRepositoryInterface::class, EloqPatientDataRepository::class);
        $this->app->singleton(QuestionResponseRepositoryInterface::class, EloqQuestionResponseRepository::class);
        $this->app->singleton(ThresholdRepositoryInterface::class, EloqThresholdRepository::class);
        $this->app->singleton(UserQuestionnaireRepositoryInterface::class, UserQuestionnaireRepository::class);
        $this->app->singleton(PractitionerRepositoryInterface::class, PractitionerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
