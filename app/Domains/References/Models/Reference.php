<?php

namespace App\Domains\References\Models;

use App\Models\CactusEntity;
use JsonSerializable;

class Reference extends CactusEntity implements JsonSerializable
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
    /** @var string|null $groupName
     * @JMS\Serializer\Annotation\SerializedName("group_name")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $groupName;
    /** @var string|null $type
     * @JMS\Serializer\Annotation\SerializedName("type")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $type;
    /** @var string|null $group
     * @JMS\Serializer\Annotation\SerializedName("group")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $group;
    /** @var string|null $link
     * @JMS\Serializer\Annotation\SerializedName("link")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $link;
    /**
     * @var array $questions
     * @JMS\Serializer\Annotation\SerializedName("questions")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Questions\Models\Question>")
     */
    private array $questions = [];

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'         => $this->id,
            'title'      => $this->title,
            'type'       => $this->type,
            'group'      => $this->group,
            'group_name' => $this->groupName ?? null,
            'link'       => $this->link ?? null,
        ];

        if ($withRelations) {
            $data['questions'] = $this->getQuestions();
        }

        return $data;
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
    public function setQuestions(array $questions): Reference
    {
        $this->questions = $questions;

        return $this;
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
     * @return $this
     */
    public function setId(int $id): Reference
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Reference
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type): Reference
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @param string|null $group
     * @return $this
     */
    public function setGroup(?string $group): Reference
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     * @return $this
     */
    public function setLink(?string $link): Reference
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     * @return Reference
     */
    public function setGroupName(string $groupName): Reference
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->getValues();
    }
}
