<?php

namespace App\Domains\Reports\Jobs;

use App\Domains\Reports\Constants\ReportTypes;
use App\Domains\Reports\Http\Services\SkillsReportGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CreateSkillsReport implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 1;

    public int $timeout = 900;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $userId,
    )
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(): void
    {
        $skillsReportGenerator = Container::getInstance()->get(SkillsReportGenerator::class);

        $userId = $this->userId;

        $skillsReportGenerator->generate($userId);
    }

    public function uniqueId(): string {
        return "REPORT_TYPE_" . ReportTypes::SKILL->value  . "_REPORT_USER_" . $this->userId;
    }
}
