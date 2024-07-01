<?php

namespace App\Domains\Tests\Models;

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
     * @var array $languages
     * @JMS\Serializer\Annotation\SerializedName("languages")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Language\Models\Language>")
     */
    private array $languages = [];


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
            'title' => $this->title
        ];

        if ($withRelations) {
            $data['languages'] = $this->getLanguages();
            $data['questions'] = $this->getQuestions();
        }
        return $data;
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
}
