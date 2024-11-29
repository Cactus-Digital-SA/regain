<?php

namespace App\Domains\Questions\Models;

use App\Domains\Instructions\Models\Instruction;
use App\Domains\Language\Models\Language;
use App\Domains\References\Models\Reference;
use App\Domains\Responses\Models\Response;
use App\Domains\Subscales\Models\Subscale;
use App\Domains\Tests\Models\Test;
use App\Models\CactusEntity;

class Question extends CactusEntity
{
    //Todo Type of the question for the UI ( dropdown, radio, multiple, checkbox)
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /** @var string $title
     * @JMS\Serializer\Annotation\SerializedName("title")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $title;
    /**
     * @var int|null $sort
     * @JMS\Serializer\Annotation\SerializedName("sort")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $sort;
    /**
     * @var int $status
     * @JMS\Serializer\Annotation\SerializedName("status")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $status;
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
     * @var int|null $instruction_id
     * @JMS\Serializer\Annotation\SerializedName("instruction_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $instruction_id;
    /**
     * @var Subscale|null $subscale
     * @JMS\Serializer\Annotation\SerializedName("subscale")
     * @JMS\Serializer\Annotation\Type("App\Domains\Subscales\Models\Subscale")
     */
    private ?Subscale $subscale;
    /** @var int|null $requiredQuestionId
     * @JMS\Serializer\Annotation\SerializedName("required_question_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $requiredQuestionId;
    /**
     * @var Question|null $requiredQuestion
     * @JMS\Serializer\Annotation\SerializedName("required_question")
     * @JMS\Serializer\Annotation\Type("App\Domains\Questions\Models\Question")
     */
    private ?Question $requiredQuestion;
    /**
     * @var Response[]|null $requiredResponses
     * @JMS\Serializer\Annotation\SerializedName("required_question")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Responses\Models\Response>")
     */
    private ?array $requiredResponses;
    /**
     * @var Response[]|null $requiredProfessions
     * @JMS\Serializer\Annotation\SerializedName("required_professions")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Responses\Models\Response>")
     */
    private ?array $requiredProfessions;
    /** @var Test $test
     * @JMS\Serializer\Annotation\SerializedName("test")
     * @JMS\Serializer\Annotation\Type("App\Domains\Tests\Models\Test")
     */
    private Test $test;
    /**
     * @var Instruction|null $instruction
     * @JMS\Serializer\Annotation\SerializedName("instruction")
     * @JMS\Serializer\Annotation\Type("App\Domains\Instructions\Models\Instruction")
     */
    private ?Instruction $instruction;
    /**
     * @var Reference[] $references
     * @JMS\Serializer\Annotation\SerializedName("references")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\References\Models\Reference>")
     */
    private array $references;
    /**
     * @var Response[] $responses
     * @JMS\Serializer\Annotation\SerializedName("responses")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Responses\Models\Response>")
     */
    private array $responses;
    /**
     * @var Language[] $languages
     * @JMS\Serializer\Annotation\SerializedName("languages")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Language\Models\Language>")
     */
    private array $languages;

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'                   => $this->id,
            'title'                => $this->title,
            'test_id'              => $this->test_id,
            'instruction_id'       => $this->instruction_id ?? null,
            'subscale_id'          => $this->subscale_id ?? null,
            'required_question_id' => $this->requiredQuestionId ?? null,
            'sort'                 => $this->sort ?? null
        ];

        if ($withRelations) {
            $data['instruction']          = $this->getInstruction();
            $data['test']                 = $this->getTest();
            $data['subscale']             = $this->getSubscale();
            $data['references']           = $this->getReferences();
            $data['responses']            = $this->getResponses();
            $data['language']             = $this->getLanguages();
            $data['required_question']    = $this->getRequiredQuestion();
            $data['required_responses']   = $this->getRequiredResponses();
            $data['required_professions'] = $this->getRequiredProfessions();
        }

        return $data;
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

    public function getTest(): Test
    {
        return $this->test;
    }

    public function setTest(Test $test): Question
    {
        $this->test = $test;

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

    /**
     * @return Question|null
     */
    public function getRequiredQuestion(): ?Question
    {
        return $this->requiredQuestion;
    }

    /**
     * @param Question|null $requiredQuestion
     * @return Question
     */
    public function setRequiredQuestion(?Question $requiredQuestion): Question
    {
        $this->requiredQuestion = $requiredQuestion;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRequiredResponses(): ?array
    {
        return $this->requiredResponses;
    }

    /**
     * @param array|null $requiredResponses
     * @return Question
     */
    public function setRequiredResponses(?array $requiredResponses): Question
    {
        $this->requiredResponses = $requiredResponses;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRequiredProfessions(): ?array
    {
        return $this->requiredProfessions;
    }

    /**
     * @param array|null $requiredProfessions
     * @return Question
     */
    public function setRequiredProfessions(?array $requiredProfessions): Question
    {
        $this->requiredProfessions = $requiredProfessions;

        return $this;
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

    public function getInstructionId(): ?int
    {
        return $this->instruction_id;
    }

    public function setInstructionId(?int $instruction_id): Question
    {
        $this->instruction_id = $instruction_id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Question
    {
        $this->title = $title;

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
     * @return Question
     */
    public function setSort(?int $sort): Question
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Question
     */
    public function setStatus(int $status): Question
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRequiredQuestionId(): ?int
    {
        return $this->requiredQuestionId;
    }

    /**
     * @param int|null $requiredQuestionId
     * @return Question
     */
    public function setRequiredQuestionId(?int $requiredQuestionId): Question
    {
        $this->requiredQuestionId = $requiredQuestionId;

        return $this;
    }
}
