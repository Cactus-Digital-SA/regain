<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Patient\Repositories\Eloquent\Models\PatientData;
use App\Domains\Practitioner\Enums\MedicalPersonnelCategory;
use App\Domains\Practitioner\Enums\MedicalPersonnelTypes;
use App\Domains\Practitioner\Repositories\Eloquent\Models\Practitioner;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use voku\helper\ASCII;

class PractitionersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // seed the medical types
        foreach (MedicalPersonnelCategory::cases() as $category) {
            DB::table('medical_type_categories')->insert([
                'type_id' => $category->value,
                'label'   => match ($category) {
                    MedicalPersonnelCategory::DOCTOR                      => "Doctor",
                    MedicalPersonnelCategory::NURSE                       => "Nurse",
                    MedicalPersonnelCategory::PSYCHOLOGIST                => "Psychologist",
                    MedicalPersonnelCategory::PSYCHOTHERAPIST             => "Psychotherapist",
                    MedicalPersonnelCategory::SPECIALLY_TRAINED_PERSONNEL => "Specially Trained Personnel",
                }
            ]);
        }

        foreach (MedicalPersonnelTypes::cases() as $type) {
            if (in_array($type->value, [1, 2, 3, 4])) {
                DB::table('medical_types')->insert([
                    'category_type_id' => MedicalPersonnelCategory::DOCTOR->value,
                    'type_id'          => $type,
                    'label'            => match ($type) {
                        MedicalPersonnelTypes::PRACTITIONER_GENERAL_PRACTITIONER => "General Practitioner",
                        MedicalPersonnelTypes::PRACTITIONER_FAMILY_PRACTITIONER  => "Family Practitioner",
                        MedicalPersonnelTypes::PRACTITIONER_PSYCHIATRIST         => "Psychiatrist",
                        MedicalPersonnelTypes::PRACTITIONER_OTHER                => "Nurse (Other)",
                    }
                ]);
            }
            if (in_array($type->value, [5, 6, 7])) {
                DB::table('medical_types')->insert([
                    'category_type_id' => MedicalPersonnelCategory::NURSE->value,
                    'type_id'          => $type,
                    'label'            => match ($type) {
                        MedicalPersonnelTypes::NURSE_GENERAL_NURSE     => "General Nurse",
                        MedicalPersonnelTypes::NURSE_PSYCHIATRIC_NURSE => "Psychiatric Nurse",
                        MedicalPersonnelTypes::NURSE_OTHER             => "Nurse (Other)",
                    }
                ]);
            }
            if (in_array($type->value, [8, 9])) {
                DB::table('medical_types')->insert([
                    'category_type_id' => MedicalPersonnelCategory::PSYCHOLOGIST->value,
                    'type_id'          => $type,
                    'label'            => match ($type) {
                        MedicalPersonnelTypes::PSYCHOLOGIST_GENERAL_PSYCHOLOGIST  => "General Psychologist",
                        MedicalPersonnelTypes::PSYCHOLOGIST_CLINICAL_PSYCHOLOGIST => "Clinical Psychologist",
                    }
                ]);
            }
            if ($type->value === 10) {
                DB::table('medical_types')->insert([
                    'category_type_id' => MedicalPersonnelCategory::PSYCHOTHERAPIST->value,
                    'type_id'          => $type->value,
                    'label'            => "Psychotherapist"
                ]);
            }
            if (in_array($type->value, [11, 12, 13])) {
                DB::table('medical_types')->insert([
                    'category_type_id' => MedicalPersonnelCategory::SPECIALLY_TRAINED_PERSONNEL->value,
                    'type_id'          => $type->value,
                    'label'            => match ($type) {
                        MedicalPersonnelTypes::SPECIALLY_TRAINED_VOLUNTEER_PSYCHOTHERAPY => "Specially Trained (Psychotherapy)",
                        MedicalPersonnelTypes::SPECIALLY_TRAINED_TRAUMA_MANAGEMENT       => "Specially Trained (Trauma Management)",
                        MedicalPersonnelTypes::SPECIALLY_TRAINED_OTHER                   => "Specially Trained (Other)",
                    }
                ]);
            }
        }

        $faker = Faker::create('uk_UA');  // Ukrainian locale

        // Get all the regions
        $regions = DB::table('regions')->pluck('id', 'name')->toArray();

        // Create 25 practitioners
        $index = 1;
        foreach ($regions as $regionName => $regionId) {
            // Create a user for the practitioner
            $user = User::create([
                'name'     => ASCII::to_ascii($faker->firstName) . ' ' . ASCII::to_ascii($faker->lastName),
                'email'    => "practitioner{$index}@example.com",
                'password' => bcrypt('password'), // Set a default password
            ]);

            // Assign the practitioner role to the user
            $role = Role::query()->where('id', RolesEnum::Practitioner->value)->first();
            $user->roles()->attach($role->id);

            // Create the practitioner record and associate with the region
            Practitioner::create([
                'user_id'                  => $user->id,
                'region_id'                => $regionId,
                'medical_type_category_id' => MedicalPersonnelTypes::PRACTITIONER_GENERAL_PRACTITIONER,
            ]);
            $index++;
        }

        $patient = User::create([
            'name'     => ASCII::to_ascii($faker->firstName) . ' ' . ASCII::to_ascii($faker->lastName),
            'email'    => "patient@example.com",
            'password' => bcrypt('password'), // Set a default password
        ]);

        $role = Role::query()->where('id', RolesEnum::Patient->value)->first();
        $patient->roles()->attach($role->id);

        PatientData::create([
            'user_id'             => $patient->id,
            'birthday'            => '1976-08-04',
            'region_id'           => '1',
            'post_code'           => '12345',
            'primary_phone'       => '123456789',
            'secondary_phone'     => '123456789',
            'accessible_mobility' => 1,
            'status'              => "Inactive"
        ]);
    }
}
