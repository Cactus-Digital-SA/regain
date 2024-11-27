<?php

namespace App\Domains\Instructions\Models;
use App\Domains\Language\Models\Language;
use App\Models\CactusEntity;

class Instruction extends CactusEntity
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;

    /**
     * @var string $content
     * @JMS\Serializer\Annotation\SerializedName("content")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $content;

    /**
     * @var Language $language
     * @JMS\Serializer\Annotation\SerializedName("language")
     * @JMS\Serializer\Annotation\Type("App\Domains\Language\Models\Language")
     */
    private Language $language;

    /**
     * @var int $languageId
     * @JMS\Serializer\Annotation\SerializedName("language_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $languageId;


    public function getValues(bool $withRelations = false): array
    {
        $data = [
            'id' => $this->id,
            'content' => $this->content,
            'language_id' => $this->languageId,
        ];

        if ($withRelations) {
            $data['language'] = $this->getLanguage();
        }

        return $data;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Instruction
    {
        $this->id = $id;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Instruction
    {
        $this->content = $content;
        return $this;
    }

    public function setLanguage(Language $language): Instruction
    {
        $this->language = $language;
        return $this;
    }

    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    public function setLanguageId(int $languageId): Instruction
    {
        $this->languageId = $languageId;
        return $this;
    }

}
