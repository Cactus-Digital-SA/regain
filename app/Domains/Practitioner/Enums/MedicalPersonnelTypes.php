<?php

namespace App\Domains\MedicalPersonnel\Enums;

enum MedicalPersonnelTypes: string
{
    case PRACTITIONER_PSYCHIATRIST = "practitioner_psychiatrist";
    case PRACTITIONER_FAMILY_PRACTITIONER = "practitioner_family";
    case PRACTITIONER_GENERAL_PRACTITIONER = "practitioner_general";
    case PRACTITIONER_OTHER = "practitioner_other";
    case NURSE_PSYCHIATRIC_NURSE = "nurse_psychiatrist";
    case NURSE_GENERAL_NURSE = "nurse_general";
    case NURSE_OTHER = "nurse_other";
    case PSYCHOLOGIST_CLINICAL_PSYCHOLOGIST = "psychologist_clinical";
    case PSYCHOLOGIST_GENERAL_PSYCHOLOGIST = "psychologist_general";
    case PSYCHOTHERAPIST = "psychotherapist";
    case SPECIALLY_TRAINED_VOLUNTEER_PSYCHOTHERAPY = "trained_volunteer_psychotherapy";
    case SPECIALLY_TRAINED_TRAUMA_MANAGEMENT = "trained_volunteer_trauma_management";
    case SPECIALLY_TRAINED_OTHER = "trained_volunteer_other";

    public function label(): string
    {
        return __('medical_type.' . $this->value);
    }
}
