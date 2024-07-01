<?php

namespace App\Domains\Tests\Models;


use App\Models\CactusEntity;

class Question extends CactusEntity
{

    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;

    /** @var Test $test
     * @JMS\Serializer\Annotation\SerializedName("test")
     * @JMS\Serializer\Annotation\Type("App\Domains\Tests\Models\Test")
     */
    private Test $test;


    /**
     * @var int $test_id
     * @JMS\Serializer\Annotation\SerializedName("test_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $test_id;

    /** @var int|null $subscale_id
     * @JMS\Serializer\Annotation\SerializedName("subscale_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $subscale_id;

    /**
     * @var Subscale|null Subscale
     * @JMS\Serializer\Annotation\SerializedName("subscale")
     * @JMS\Serializer\Annotation\Type("App\Domains\Tests\Models\Subscale")
     */
    private ?Subscale $subscale;


    /**
     * @var Instruction|null $instruction
     * @JMS\Serializer\Annotation\SerializedName("instruction")
     * @JMS\Serializer\Annotation\Type("App\Domains\Tests\Models\Instruction")
     */
    private ?Instruction $instruction;


    /**
     * @var int|null $instruction_id
     * @JMS\Serializer\Annotation\SerializedName("instruction_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $instruction_id;

    /**
     * @var array $references
     * @JMS\Serializer\Annotation\SerializedName("references")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Tests\Models\Reference>")
     */
    private array $references;

    /**
     * @var array $responses
     * @JMS\Serializer\Annotation\SerializedName("responses")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Tests\Models\Response>")
     */
    private array $responses;

    /**
     * @var array $languages
     * @JMS\Serializer\Annotation\SerializedName("languages")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Language\Models\Language>")
     */
    private array $languages;


    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id' => $this->id,
            'test_id' => $this->test_id,
            'instruction_id' => $this->instruction_id ?? null,
            'subscale_id' => $this->subscale_id ?? null
        ];

        if ($withRelations) {
            $data['instruction'] = $this->getInstruction();
            $data['test'] = $this->getTest();
            $data['subscale'] = $this->getSubscale();
            $data['references'] = $this->getReferences();
            $data['responses'] = $this->getResponses();
            $data['language'] = $this->getLanguages();
        }
        return $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Question
    {
        $this->id = $id;
        return $this;
    }

    public function getTest(): Test
    {
        return $this->test;
    }

    public function setTest(Test $test): Question
    {
        $this->test = $test;
        return $this;
    }

    public function getTestId(): int
    {
        return $this->test_id;
    }

    public function setTestId(int $test_id): Question
    {
        $this->test_id = $test_id;
        return $this;
    }


    public function getSubscaleId(): ?int
    {
        return $this->subscale_id;
    }

    public function setSubscaleId(?int $subscaleId): Question
    {
        $this->subscale_id = $subscaleId;
        return $this;
    }

    public function getSubscale(): ?Subscale
    {
        return $this->subscale;
    }

    public function setSubscale(?Subscale $subscale): Question
    {
        $this->subscale = $subscale;
        return $this;
    }


    public function getInstruction(): ?Instruction
    {
        return $this->instruction;
    }

    public function setInstruction(?Instruction $instruction): Question
    {
        $this->instruction = $instruction;
        return $this;
    }

    public function getInstructionId(): ?int
    {
        return $this->instruction_id;
    }

    public function setInstructionId(?int $instruction_id): Question
    {
        $this->instruction_id = $instruction_id;
        return $this;
    }


    public function getReferences(): array
    {
        return $this->references;
    }

    public function setReferences(array $references): Question
    {
        $this->references = $references;
        return $this;
    }

    public function getResponses(): array
    {
        return $this->responses;
    }

    public function setResponses(array $responses): Question
    {
        $this->responses = $responses;
        return $this;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): Question
    {
        $this->languages = $languages;
        return $this;
    }
}
