<?php

namespace App\Domains\Reports\Http\Presenters;

use App\Domains\References\Models\Reference;
use DateTime;
use JsonSerializable;
use JMS\Serializer\Annotation as Serializer;

class TestPresenter implements JsonSerializable
{
    /**
     * @Serializer\Type("int")
     */
    private int $id;

    /**
     * @Serializer\Type("string")
     */
    private string $name;

    /**
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private DateTime $completedAt;

    /**
     * @var Reference[]
     * @Serializer\Type("array<App\Domains\References\Models\Reference>")
     */
    private array $scientificReference = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): TestPresenter
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): TestPresenter
    {
        $this->name = $name;
        return $this;
    }

    public function getCompletedAt(): DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(DateTime $completedAt): TestPresenter
    {
        $this->completedAt = $completedAt;
        return $this;
    }

    /**
     * @return Reference[]
     */
    public function getScientificReference(): array
    {
        return $this->scientificReference;
    }

    /**
     * @param array $scientificReference
     * @return $this
     */
    public function setScientificReference(array $scientificReference): TestPresenter
    {
        $this->scientificReference = $scientificReference;
        return $this;
    }

    /**
     * Convert the object to an array for JSON encoding
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'completedAt' => $this->completedAt->format('Y-m-d H:i:s'), // Format DateTime properly
            'scientificReference' => array_map(fn(Reference $ref) => $ref->jsonSerialize(), $this->scientificReference),
        ];
    }
}
