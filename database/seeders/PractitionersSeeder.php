<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\MedicalPersonnel\Enums\MedicalPersonnelCategory;
use App\Domains\MedicalPersonnel\Enums\MedicalPersonnelTypes;
use App\Domains\Patient\Repositories\Eloquent\Models\PatientData;
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
                'value' => $category->value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach (MedicalPersonnelTypes::cases() as $type) {
            if (in_array($type->value, [
                    'practitioner_psychiatrist',
                    'practitioner_family',
                    'practitioner_general',
                    'practitioner_other'
                ])) {
                DB::table('medical_types')->insert([
                    'category_type' => MedicalPersonnelCategory::DOCTOR->value,
                    'value' => $type->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if (in_array($type->value, [
                'nurse_psychiatrist',
                'nurse_general',
                'nurse_other'
            ])) {
                DB::table('medical_types')->insert([
                    'category_type' => MedicalPersonnelCategory::NURSE->value,
                    'value' => $type->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if (in_array($type->value, [
                'psychologist_clinical',
                'psychologist_general'
            ])) {
                DB::table('medical_types')->insert([
                    'category_type' => MedicalPersonnelCategory::PSYCHOLOGIST->value,
                    'value' => $type->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if ($type->value == "psychotherapist") {
                DB::table('medical_types')->insert([
                    'category_type' => MedicalPersonnelCategory::PSYCHOTHERAPIST->value,
                    'value' => $type->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if (in_array($type->value, [
                'trained_volunteer_psychotherapy',
                'trained_volunteer_trauma_management',
                'trained_volunteer_other'
            ])) {
                DB::table('medical_types')->insert([
                    'category_type' => MedicalPersonnelCategory::PSYCHOLOGIST->value,
                    'value' => $type->value,
                    'created_at' => now(),
                    'updated_at' => now(),
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
                'user_id'   => $user->id,
                'region_id' => $regionId,
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
