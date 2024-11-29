<?php

namespace App\Domains\Language\Models;

use App\Models\CactusEntity;

class Language extends CactusEntity
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /**
     * @var string $name
     * @JMS\Serializer\Annotation\SerializedName("name")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $name = "";
    /**
     * @var string $code
     * @JMS\Serializer\Annotation\SerializedName("code")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $code = "";
    /**
     * @var string $locale
     * @JMS\Serializer\Annotation\SerializedName("locale")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $locale = "";
    /**
     * @var string|null $image
     * @JMS\Serializer\Annotation\SerializedName("image")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $image;
    /**
     * @var int $status
     * @JMS\Serializer\Annotation\SerializedName("status")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $status = 1;

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'     => $this->id,
            'name'   => $this->name,
            'code'   => $this->code,
            'locale' => $this->locale,
            'image'  => $this->image,
            'status' => $this->status,
        ];

        return $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Language
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Language
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): Language
    {
        $this->code = $code;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): Language
    {
        $this->locale = $locale;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): Language
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): Language
    {
        $this->status = $status;

        return $this;
    }
}
