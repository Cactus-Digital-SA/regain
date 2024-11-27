<?php

namespace App\Domains\Subscales\Models;

use App\Domains\Tests\Models\Test;
use App\Models\CactusEntity;

class Subscale extends CactusEntity
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;


    /** @var string $name
     * @JMS\Serializer\Annotation\SerializedName("name")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $name;

    /**
     * @var int|null $sort
     * @JMS\Serializer\Annotation\SerializedName("sort")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $sort;

    /**
     * @var int $requiredQuestions
     * @JMS\Serializer\Annotation\SerializedName("required_questions")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $requiredQuestions;

    /** @var Test $test
     * @JMS\Serializer\Annotation\SerializedName("test")
     * @JMS\Serializer\Annotation\Type("App\Domains\Tests\Models\Test")
     */
    private Test $test;

    /** @var int $testId
     * @JMS\Serializer\Annotation\SerializedName("test_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $testId;

    /**
     * @var array $questions
     * @JMS\Serializer\Annotation\SerializedName("questions")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Questions\Models\Question>")
     */
    private array $questions = [];

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'test_id' => $this->testId,
            'sort' => $this->sort ?? null,
            'required_questions' => $this->requiredQuestions ?? 0
        ];

        if ($withRelations) {
            $data['test'] = $this->getTest();
            $data['questions'] = $this->getQuestions();
        }
        return $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Subscale
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Subscale
    {
        $this->name = $name;
        return $this;
    }

    public function getTest(): Test
    {
        return $this->test;
    }

    public function setTest(Test $test): Subscale
    {
        $this->test = $test;
        return $this;
    }

    public function getTestId(): int
    {
        return $this->testId;
    }

    public function setTestId(int $testId): Subscale
    {
        $this->testId = $testId;
        return $this;
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param array $questions
     * @return $this
     */
    public function setQuestions(array $questions): Subscale
    {
        $this->questions = $questions;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     * @return Subscale
     */
    public function setSort(?int $sort): Subscale
    {
        $this->sort = $sort;
        return $this;
    }


    /**
     * @return int
     */
    public function getRequiredQuestions(): int
    {
        return $this->requiredQuestions;
    }

    /**
     * @param int $requiredQuestions
     * @return Subscale
     */
    public function setRequiredQuestions(int $requiredQuestions): Subscale
    {
        $this->requiredQuestions = $requiredQuestions;
        return $this;
    }




}
