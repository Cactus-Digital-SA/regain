<?php

namespace App\Domains\Region\Models;

use App\Models\CactusEntity;

class Region extends CactusEntity
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
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Region
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Region
    {
        $this->name = $name;

        return $this;
    }

    public function getValues(bool $withRelations = true): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}
