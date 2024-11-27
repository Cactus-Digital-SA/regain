<?php

namespace App\Domains\Results\Models;

use App\Domains\Subscales\Models\Subscale;
use App\Domains\Tests\Models\Test;
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
     * @var string $interpretation
     * @JMS\Serializer\Annotation\SerializedName("interpretation")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $interpretation;


    /**
     * @var string $rangeStart
     * @JMS\Serializer\Annotation\SerializedName("range_start")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $rangeStart;

    /**
     * @var string $rangeEnd
     * @JMS\Serializer\Annotation\SerializedName("range_end")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $rangeEnd;


    /**
     * @var int $test_id
     * @JMS\Serializer\Annotation\SerializedName("test_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $test_id;

    /**
     * @var int|null $subscale_id
     * @JMS\Serializer\Annotation\SerializedName("subscale_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $subscale_id;

    /**
     * @var Test $test
     * @JMS\Serializer\Annotation\SerializedName("test")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Tests\Models\Test>")
     */
    private Test $test;

    /**
     * @var Subscale|null subscale
     * @JMS\Serializer\Annotation\SerializedName("subscale")
     * @JMS\Serializer\Annotation\Type("App\Domains\Subscales\Models\Subscale")
     */
    private ?Subscale $subscale;

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id' => $this->id,
            'interpretation' => $this->interpretation,
            'range_start' => $this->rangeStart,
            'range_end' => $this->rangeEnd,
            'test_id' => $this->test_id,
            'subscale_id' => $this->subscale_id ?? null,
        ];

        if($withRelations) {
            $data['tests'] = $this->getTest();
            $data['subscales'] = $this->getSubscale();
        }

        return $data;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Threshold
     */
    public function setId(int $id): Threshold
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getInterpretation(): string
    {
        return $this->interpretation;
    }

    /**
     * @param string $interpretation
     * @return Threshold
     */
    public function setInterpretation(string $interpretation): Threshold
    {
        $this->interpretation = $interpretation;
        return $this;
    }

    /**
     * @return string
     */
    public function getRangeStart(): string
    {
        return $this->rangeStart;
    }

    /**
     * @param string $rangeStart
     * @return Threshold
     */
    public function setRangeStart(string $rangeStart): Threshold
    {
        $this->rangeStart = $rangeStart;
        return $this;
    }

    /**
     * @return string
     */
    public function getRangeEnd(): string
    {
        return $this->rangeEnd;
    }

    /**
     * @param string $rangeEnd
     * @return Threshold
     */
    public function setRangeEnd(string $rangeEnd): Threshold
    {
        $this->rangeEnd = $rangeEnd;
        return $this;
    }

    /**
     * @return int
     */
    public function getTestId(): int
    {
        return $this->test_id;
    }

    /**
     * @param int $test_id
     * @return Threshold
     */
    public function setTestId(int $test_id): Threshold
    {
        $this->test_id = $test_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSubscaleId(): ?int
    {
        return $this->subscale_id;
    }

    /**
     * @param int|null $subscale_id
     * @return Threshold
     */
    public function setSubscaleId(?int $subscale_id): Threshold
    {
        $this->subscale_id = $subscale_id;
        return $this;
    }




    /**
     * @return Test
     */
    public function getTest(): Test
    {
        return $this->test;
    }

    /**
     * @param Test $test
     * @return Threshold
     */
    public function setTest(Test $test): Threshold
    {
        $this->test = $test;
        return $this;
    }

    /**
     * @return Subscale
     */
    public function getSubscale(): Subscale
    {
        return $this->subscale;
    }

    /**
     * @param Subscale $subscale
     * @return Threshold
     */
    public function setSubscale(Subscale $subscale): Threshold
    {
        $this->subscale = $subscale;
        return $this;
    }


}
