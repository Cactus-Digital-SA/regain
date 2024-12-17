<?php

namespace App\Domains\Reports\Http\Presenters;

use DateTime;

class TestPresenter
{
    private int $id;
    private string $name;
    private DateTime $completedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): TestPresenter
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): TestPresenter
    {
        $this->name = $name;

        return $this;
    }

    public function getCompletedAt(): DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(DateTime $completedAt): TestPresenter
    {
        $this->completedAt = $completedAt;

        return $this;
    }
}