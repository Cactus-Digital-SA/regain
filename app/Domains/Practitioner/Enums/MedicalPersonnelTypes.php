<?php

namespace App\Domains\Practitioner\Enums;

enum MedicalPersonnelTypes: int
{
    case PRACTITIONER_PSYCHIATRIST                 = 1;
    case PRACTITIONER_FAMILY_PRACTITIONER          = 2;
    case PRACTITIONER_GENERAL_PRACTITIONER         = 3;
    case PRACTITIONER_OTHER                        = 4;
    case NURSE_PSYCHIATRIC_NURSE                   = 5;
    case NURSE_GENERAL_NURSE                       = 6;
    case NURSE_OTHER                               = 7;
    case PSYCHOLOGIST_CLINICAL_PSYCHOLOGIST        = 8;
    case PSYCHOLOGIST_GENERAL_PSYCHOLOGIST         = 9;
    case PSYCHOTHERAPIST                           = 10;
    case SPECIALLY_TRAINED_VOLUNTEER_PSYCHOTHERAPY = 11;
    case SPECIALLY_TRAINED_TRAUMA_MANAGEMENT       = 12;
    case SPECIALLY_TRAINED_OTHER                   = 13;
}
