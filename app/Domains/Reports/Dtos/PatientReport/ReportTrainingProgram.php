<?php

namespace App\Domains\Reports\Dtos\PatientReport;

class ReportTrainingProgram
{
    private int $hours = 0;

    /**
     * @var string[] $hourlyTask
     */
    private array $hourlyTask = [];

    public function getHours(): int
    {
        return $this->hours;
    }

    public function setHours(int $hours): ReportTrainingProgram
    {
        $this->hours = $hours;
        return $this;
    }

    public function getHourlyTask(): array
    {
        return $this->hourlyTask;
    }

    public function setHourlyTask(array $hourlyTask): ReportTrainingProgram
    {
        $this->hourlyTask = $hourlyTask;
        return $this;
    }
}
