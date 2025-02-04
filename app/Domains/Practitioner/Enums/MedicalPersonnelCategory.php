<?php

namespace App\Domains\Practitioner\Enums;

enum MedicalPersonnelCategory: int
{
    case DOCTOR                      = 1;
    case NURSE                       = 2;
    case PSYCHOLOGIST                = 3;
    case PSYCHOTHERAPIST             = 4;
    case SPECIALLY_TRAINED_PERSONNEL = 5;
}
