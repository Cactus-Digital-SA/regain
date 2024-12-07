<?php

namespace App\Domains\Thresholds\Models;

use App\Domains\Subscales\Models\Subscale;
use App\Domains\Tests\Models\Test;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;
use App\Models\CactusEntity;

class Threshold extends CactusEntity
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /**
     * @var int $testId
     * @JMS\Serializer\Annotation\SerializedName("test_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $testId;
    /**
     * @var ?int $subscaleId
     * @JMS\Serializer\Annotation\SerializedName("subscale_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $subscaleId = null;
    /**
     * @var ?int $questionStart
     * @JMS\Serializer\Annotation\SerializedName("question_start")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $questionStart = null;
    /**
     * @var ?int $questionEnd
     * @JMS\Serializer\Annotation\SerializedName("question_end")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $questionEnd = null;
    /**
     * @var ThresholdDisplayType $displayType
     * @JMS\Serializer\Annotation\SerializedName("display_type")
     * @JMS\Serializer\Annotation\Type("enum<'App\Domains\Thresholds\Models\Constants\ThresholdDisplayType'>")
     */
    private ThresholdDisplayType $displayType;
    /**
     * @var ?Test $test
     * @JMS\Serializer\Annotation\SerializedName("test")
     * @JMS\Serializer\Annotation\Type("App\Domains\Tests\Models\Test")
     */
    private ?Test $test = null;
    /**
     * @var ?Subscale subscale
     * @JMS\Serializer\Annotation\SerializedName("subscale")
     * @JMS\Serializer\Annotation\Type("App\Domains\Subscales\Models\Subscale")
     */
    private ?Subscale $subscale = null;
    /**
     * @var ThresholdSubscaleLimit[] subscaleLimits
     * @JMS\Serializer\Annotation\SerializedName("subscaleLimits")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Thresholds\Models\ThresholdSubscaleLimit>")
     */
    private array $subscaleLimits = [];
    /**
     * @var ThresholdTestLimit[] testLimits
     * @JMS\Serializer\Annotation\SerializedName("testLimits")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Thresholds\Models\ThresholdTestLimit>")
     */
    private array $testLimits = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Threshold
    {
        $this->id = $id;

        return $this;
    }

    public function getTestId(): int
    {
        return $this->testId;
    }

    public function setTestId(int $testId): Threshold
    {
        $this->testId = $testId;

        return $this;
    }

    public function getSubscaleId(): ?int
    {
        return $this->subscaleId;
    }

    public function setSubscaleId(?int $subscaleId): Threshold
    {
        $this->subscaleId = $subscaleId;

        return $this;
    }

    public function getQuestionStart(): ?int
    {
        return $this->questionStart;
    }

    public function setQuestionStart(?int $questionStart): Threshold
    {
        $this->questionStart = $questionStart;

        return $this;
    }

    public function getQuestionEnd(): ?int
    {
        return $this->questionEnd;
    }

    public function setQuestionEnd(?int $questionEnd): Threshold
    {
        $this->questionEnd = $questionEnd;

        return $this;
    }

    public function getDisplayType(): ThresholdDisplayType
    {
        return $this->displayType;
    }

    public function setDisplayType(ThresholdDisplayType $displayType): Threshold
    {
        $this->displayType = $displayType;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): Threshold
    {
        $this->test = $test;

        return $this;
    }

    public function getSubscale(): ?Subscale
    {
        return $this->subscale;
    }

    public function setSubscale(?Subscale $subscale): Threshold
    {
        $this->subscale = $subscale;

        return $this;
    }

    /**
     * @return []
     */
    public function getSubscaleLimits(): array
    {
        return $this->subscaleLimits;
    }

    /**
     * @param ThresholdSubscaleLimit[] $subscaleLimits
     * @return $this
     */
    public function setSubscaleLimits(array $subscaleLimits): Threshold
    {
        $this->subscaleLimits = $subscaleLimits;

        return $this;
    }

    public function getTestLimits(): array
    {
        return $this->testLimits;
    }

    public function setTestLimits(array $testLimits): Threshold
    {
        $this->testLimits = $testLimits;

        return $this;
    }

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'             => $this->id,
            'test_id'        => $this->testId,
            'subscale_id'    => $this->subscaleId ?? null,
            'question_start' => $this->questionStart,
            'question_end'   => $this->questionEnd,
            'display_type'   => $this->displayType,
        ];

        if ($withRelations) {
            $data['tests']          = $this->getTest();
            $data['subscales']      = $this->getSubscale();
            $data['subscaleLimits'] = $this->getSubscaleLimits();
            $data['testLimits']     = $this->getTestLimits();
        }

        return $data;
    }
}
