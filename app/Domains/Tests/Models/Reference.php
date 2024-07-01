<?php

namespace App\Domains\Tests\Models;

use App\Models\CactusEntity;

class Reference extends CactusEntity
{

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

    /** @var string|null $type
     * @JMS\Serializer\Annotation\SerializedName("type")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $type;

    /** @var string|null group
     * @JMS\Serializer\Annotation\SerializedName("group")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $group;

    /**
     * @var array $questions
     * @JMS\Serializer\Annotation\SerializedName("questions")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Tests\Models\Question>")
     */
    private array $questions = [];

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'group' => $this->group,
        ];

        if($withRelations){
            $data['questions'] = $this->getQuestions();
        }

        return $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Reference
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Reference
    {
        $this->title = $title;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): Reference
    {
        $this->type = $type;
        return $this;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function setGroup(?string $group): Reference
    {
        $this->group = $group;
        return $this;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function setQuestions(array $questions): Reference
    {
        $this->questions = $questions;
        return $this;
    }


}
