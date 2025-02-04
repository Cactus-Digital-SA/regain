<?php

namespace App\Domains\MedicalPersonnel\Enums;

enum MedicalPersonnelCategory: string
{
    case DOCTOR = 'doctor';
    case NURSE = 'nurse';
    case PSYCHOLOGIST = 'psychologist';
    case PSYCHOTHERAPIST = 'psychotherapist';
    case SPECIALLY_TRAINED_PERSONNEL = 'specially-trained-personnel';

    public function label(): string
    {
        return __('medical_type_category.' . $this->value);
    }
}
