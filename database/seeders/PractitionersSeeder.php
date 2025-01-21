<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
use App\Domains\Auth\Repositories\Eloquent\Models\User;
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
