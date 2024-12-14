<?php

namespace App\Domains\Patient\Models;

use App\Models\CactusEntity;

class Patient extends CactusEntity
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /**
     * @var int|null $userId
     * @JMS\Serializer\Annotation\SerializedName("user_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $userId;
    private PatientData $patientData;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Patient
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): Patient
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPatientData(): PatientData
    {
        return $this->patientData;
    }

    public function setPatientData(PatientData $patientData): Patient
    {
        $this->patientData = $patientData;

        return $this;
    }

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'     => $this->id,
            'userId' => $this->userId,
        ];

        if ($withRelations) {
            $data['patientData'] = $this->patientData;
        }

        return $data;
    }
}
