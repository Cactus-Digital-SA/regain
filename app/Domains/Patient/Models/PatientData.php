<?php

namespace App\Domains\Patient\Models;

use App\Domains\Auth\Models\User;
use App\Models\CactusEntity;
use Illuminate\Http\Request;
use Nette\Utils\DateTime;

class PatientData extends CactusEntity
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

    /**
     * @var DateTime|null $birthday
     * @JMS\Serializer\Annotation\SerializedName("birthday")
     * @JMS\Serializer\Annotation\Type("DateTime<'Y-m-d'>")
     */
    private ?DateTime $birthday = null;

    /**
     * @var int|null $regionId
     * @JMS\Serializer\Annotation\SerializedName("region_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $regionId;

    /**
     * @var int|null $postCode
     * @JMS\Serializer\Annotation\SerializedName("post_code")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $postCode;

    /**
     * @var string|null $primaryPhone
     * @JMS\Serializer\Annotation\SerializedName("primary_phone")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $primaryPhone;

    /**
     * @var string|null $secondaryPhone
     * @JMS\Serializer\Annotation\SerializedName("secondary_phone")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $secondaryPhone;

    /**
     * @var string|null $accessibleMobility
     * @JMS\Serializer\Annotation\SerializedName("accessible_mobility")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $accessibleMobility;

    /**
     * @var string|null $notes
     * @JMS\Serializer\Annotation\SerializedName("notes")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private ?string $notes;

    /**
     * @var ?User $user
     * @JMS\Serializer\Annotation\SerializedName("user")
     * @JMS\Serializer\Annotation\Type("App\Domains\Auth\Models\User")
     */
    private ?User $user;

//    /**
//     * @var ?Region $region
//     * @JMS\Serializer\Annotation\SerializedName("residence_area")
//     * @JMS\Serializer\Annotation\Type("App\Domains\GeoDataAreas\Models\GeoDataArea")
//     */
//    private ?Region $region;

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'          => $this->id,
            'userId'     => $this->userId,
            'birthday'    => $this->birthday,
            'regionId'   => $this->regionId,
            'post_code'   => $this->postCode,
            'primaryPhone' => $this->primaryPhone,
            'secondaryPhone' => $this->secondaryPhone,
            'accessibleMobility' => $this->accessibleMobility,
            'notes'       => $this->notes,
        ];

        if ($withRelations) {
            $data['user'] = $this->user;
        }

        return $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): PatientData
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): PatientData
    {
        $this->userId = $userId;
        return $this;
    }

    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?DateTime $birthday): PatientData
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getRegionId(): ?int
    {
        return $this->regionId;
    }

    public function setRegionId(?int $regionId): PatientData
    {
        $this->regionId = $regionId;
        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    public function setPostCode(?int $postCode): PatientData
    {
        $this->postCode = $postCode;
        return $this;
    }

    public function getPrimaryPhone(): ?string
    {
        return $this->primaryPhone;
    }

    public function setPrimaryPhone(?string $primaryPhone): PatientData
    {
        $this->primaryPhone = $primaryPhone;
        return $this;
    }

    public function getSecondaryPhone(): ?string
    {
        return $this->secondaryPhone;
    }

    public function setSecondaryPhone(?string $secondaryPhone): PatientData
    {
        $this->secondaryPhone = $secondaryPhone;
        return $this;
    }

    public function getAccessibleMobility(): ?string
    {
        return $this->accessibleMobility;
    }

    public function setAccessibleMobility(?string $accessibleMobility): PatientData
    {
        $this->accessibleMobility = $accessibleMobility;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): PatientData
    {
        $this->notes = $notes;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): PatientData
    {
        $this->user = $user;
        return $this;
    }

    public static function fromRequest(Request $request): PatientData
    {
        $patientDataDTO = new PatientData();

        return $patientDataDTO
            ->setUserId($request['user_id'])
            ->setBirthday($request['birthday'])
            ->setRegionId($request['region_id'])
            ->setPostCode($request['post_code'])
            ->setPrimaryPhone($request['primary_phone'])
            ->setSecondaryPhone($request['secondary_phone'])
            ->setAccessibleMobility($request['accessible_mobility'])
            ->setNotes($request['notes']);
    }

}
