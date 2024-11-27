<?php

namespace App\Domains\CareProvider\Model;

use App\Domains\Auth\Models\User;

class Practitioner extends User
{

    //Todo create new Patient with connection to Referral
    //Todo access results for each patient
    //Todo the practitioner can have multiple referrals
    //Todo the practitioner can have multiple patients
    //Todo notify the practitioner after a tests is finished based on the test

     /** Todo
     * Practitioner it will have a ability to give new test to patients.
     * Some required information will have to be added from the practitioner
     * if the patient finishes the a certain Test and i want to give access to new tests(eg. trauma test and goes to skills test).
     */

    public function getValues(bool $withRelations = true):array
    {

    }

}
