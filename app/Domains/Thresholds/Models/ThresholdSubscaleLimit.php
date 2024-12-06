<?php

namespace App\Domains\Thresholds\Models;

use App\Models\CactusEntity;

class ThresholdSubscaleLimit extends CactusEntity
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /**
     * @var int $thresholdId
     * @JMS\Serializer\Annotation\SerializedName("threshold_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $thresholdId;
    /**
     * @var int $low
     * @JMS\Serializer\Annotation\SerializedName("low")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $low;
    /**
     * @var int $high
     * @JMS\Serializer\Annotation\SerializedName("high")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $high;
    /**
     * @var string $label
     * @JMS\Serializer\Annotation\SerializedName("label")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $label;
    /**
     * @var string $notes
     * @JMS\Serializer\Annotation\SerializedName("notes")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $notes;
    /**
     * @var Threshold $theshold
     * @JMS\Serializer\Annotation\SerializedName("threshold")
     * @JMS\Serializer\Annotation\Type("<App\Domains\Thresholds\Models\Threshold>")
     */
    private Threshold $threshold;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): ThresholdSubscaleLimit
    {
        $this->id = $id;

        return $this;
    }

    public function getThresholdId(): int
    {
        return $this->thresholdId;
    }

    public function setThresholdId(int $thresholdId): ThresholdSubscaleLimit
    {
        $this->thresholdId = $thresholdId;

        return $this;
    }

    public function getLow(): int
    {
        return $this->low;
    }

    public function setLow(int $low): ThresholdSubscaleLimit
    {
        $this->low = $low;

        return $this;
    }

    public function getHigh(): int
    {
        return $this->high;
    }

    public function setHigh(int $high): ThresholdSubscaleLimit
    {
        $this->high = $high;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): ThresholdSubscaleLimit
    {
        $this->label = $label;

        return $this;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): ThresholdSubscaleLimit
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'           => $this->id,
            'threshold_id' => $this->thresholdId,
            'low'          => $this->low,
            'high'         => $this->high,
            'label'        => $this->label,
            'notes'        => $this->notes,
        ];

        if ($withRelations) {
            $data['threshold'] = $this->getThreshold();
        }

        return $data;
    }

    public function getThreshold(): Threshold
    {
        return $this->threshold;
    }

    public function setThreshold(Threshold $threshold): ThresholdSubscaleLimit
    {
        $this->threshold = $threshold;

        return $this;
    }
}
