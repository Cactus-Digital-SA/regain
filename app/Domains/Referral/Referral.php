<?php

namespace App\Domains\Referral;

use App\Models\CactusEntity;

class Referral extends CactusEntity
{

    //Todo the referral can have a list of users
    //Todo Name of the referral
    //Todo create an admin for the referral with phone

    //Todo the admin of the referral can create Care Provider that can be attached to many referrals

    public function getValues(bool $withRelations = true): array
    {
        // TODO: Implement getValues() method.
    }
}
