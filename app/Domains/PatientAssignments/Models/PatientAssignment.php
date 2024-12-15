<?php

namespace App\Domains\PatientAssignments\Models;

use App\Domains\Auth\Models\User;
use App\Models\CactusEntity;

class PatientAssignment extends CactusEntity
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /**
     * @var int $practitionerUserId
     * @JMS\Serializer\Annotation\SerializedName("practitioner_user_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $practitionerUserId;
    /**
     * @var int $patientUserId
     * @JMS\Serializer\Annotation\SerializedName("patient_user_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $patientUserId;
    /**
     * @var User $practitionerUser
     * @JMS\Serializer\Annotation\SerializedName("practitioner_user")
     * @JMS\Serializer\Annotation\Type("App\Domains\Auth\Models\User")
     */
    private User $practitionerUser;
    /**
     * @var User $patientUser
     * @JMS\Serializer\Annotation\SerializedName("patient_user")
     * @JMS\Serializer\Annotation\Type("App\Domains\Auth\Models\User")
     */
    private User $patientUser;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): PatientAssignment
    {
        $this->id = $id;

        return $this;
    }

    public function getPractitionerId(): int
    {
        return $this->practitionerUserId;
    }

    public function setPractitionerId(int $practitionerUserId): PatientAssignment
    {
        $this->practitionerUserId = $practitionerUserId;

        return $this;
    }

    public function getPatientUserId(): int
    {
        return $this->patientUserId;
    }

    public function setPatientUserId(int $patientUserId): PatientAssignment
    {
        $this->patientUserId = $patientUserId;

        return $this;
    }

    public function getPractitionerUserId(): int
    {
        return $this->practitionerUserId;
    }

    public function setPractitionerUserId(int $practitionerUserId): PatientAssignment
    {
        $this->practitionerUserId = $practitionerUserId;

        return $this;
    }

    public function getPractitionerUser(): User
    {
        return $this->practitionerUser;
    }

    public function setPractitionerUser(User $practitionerUser): PatientAssignment
    {
        $this->practitionerUser = $practitionerUser;

        return $this;
    }

    public function getPatientUser(): User
    {
        return $this->patientUser;
    }

    public function setPatientUser(User $patientUser): PatientAssignment
    {
        $this->patientUser = $patientUser;

        return $this;
    }

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'              => $this->id,
            'practitioner_id' => $this->practitionerUserId,
            'patient_id'      => $this->patientUserId,
        ];

        if ($withRelations) {
            $data['practitioner_user'] = $this->practitionerUser;
            $data['patient_user']      = $this->patientUser;
        }

        return $data;
    }
}
