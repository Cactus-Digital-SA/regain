<?php

namespace App\Domains\Responses\Models;

use App\Models\CactusEntity;

class Response extends CactusEntity
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
    /**
     * @var int|null $sort
     * @JMS\Serializer\Annotation\SerializedName("sort")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $sort;
    /**
     * @var int $type
     * @JMS\Serializer\Annotation\SerializedName("type")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $type;
    /**
     * @var array $languages
     * @JMS\Serializer\Annotation\SerializedName("languages")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Language\Models\Language>")
     */
    private array $languages = [];
    /**
     * @var array $questions
     * @JMS\Serializer\Annotation\SerializedName("questions")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Questions\Models\Question>")
     */
    private array $questions = [];

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'    => $this->id,
            'title' => $this->title,
            'type'  => $this->type,
            'sort'  => $this->sort ?? null
        ];

        if ($withRelations) {
            $data['languages'] = $this->getLanguages();
            $data['questions'] = $this->getQuestions();
        }

        return $data;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): Response
    {
        $this->languages = $languages;

        return $this;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function setQuestions(array $questions): Response
    {
        $this->questions = $questions;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Response
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Response
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
     * @return Response
     */
    public function setSort(?int $sort): Response
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return Response
     */
    public function setType(int $type): Response
    {
        $this->type = $type;

        return $this;
    }
}
