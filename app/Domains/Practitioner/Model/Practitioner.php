<?php

namespace App\Domains\Practitioner\Model;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Region\Repositories\Eloquent\Models\Region;

class Practitioner extends User
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /**
     * @var int $userid
     * @JMS\Serializer\Annotation\SerializedName("user_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $userId;
    /**
     * @var int $regionId
     * @JMS\Serializer\Annotation\SerializedName("region_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $regionId;
    /**
     * @var User $user
     * @JMS\Serializer\Annotation\SerializedName("user")
     * @JMS\Serializer\Annotation\Type("App\Domains\Auth\Models\User")
     */
    private User $user;
    /**
     * @var Region $region
     * @JMS\Serializer\Annotation\SerializedName("region")
     * @JMS\Serializer\Annotation\Type("App\Domains\Region\Repositories\Eloquent\Models\Region")
     */
    private Region $region;
    /**
     * @var PatientData[] $assignedPatients
     * @JMS\Serializer\Annotation\SerializedName("assignedPatients")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Patient\Models\PatientData>")
     */
    private array $assignedPatients = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Practitioner
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): Practitioner
    {
        $this->userId = $userId;

        return $this;
    }

    public function getRegionId(): int
    {
        return $this->regionId;
    }

    public function setRegionId(int $regionId): Practitioner
    {
        $this->regionId = $regionId;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Practitioner
    {
        $this->user = $user;

        return $this;
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): Practitioner
    {
        $this->region = $region;

        return $this;
    }

    public function getAssignedPatients(): array
    {
        return $this->assignedPatients;
    }

    public function setAssignedPatients(array $assignedPatients): Practitioner
    {
        $this->assignedPatients = $assignedPatients;

        return $this;
    }

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'        => $this->id,
            'user_id'   => $this->userId,
            'region_id' => $this->regionId,
        ];

        if ($withRelations) {
            $data['user']             = $this->getUser();
            $data['region']           = $this->getRegion();
            $data['assignedPatients'] = $this->getAssignedPatients();
        }

        return $data;
    }
}
