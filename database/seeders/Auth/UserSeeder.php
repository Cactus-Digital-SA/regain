<?php

declare(strict_types = 1);

namespace Database\Seeders\Auth;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Patient\Models\PatientData;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run(): void
    {
        // Add the master administrator, user id of 1
        User::create([
            'name'              => 'Super Admin',
            'email'             => 'admin@cactusweb.gr',
            'password'          => bcrypt('123456'),
            'email_verified_at' => now(),
            'active'            => true,
        ]);

        User::create([
            'name'              => 'Regain user',
            'email'             => 'user@regain',
            'password'          => bcrypt('123456'),
            'email_verified_at' => now(),
            'active'            => true,
        ]);

        User::create([
            'name'              => 'practitioner',
            'email'             => 'practitioner@regain',
            'password'          => bcrypt('123456'),
            'email_verified_at' => now(),
            'active'            => true,
        ]);

        $user = User::create([
            'name'              => 'patient',
            'email'             => 'patient@regain',
            'password'          => bcrypt('123456'),
            'email_verified_at' => now(),
            'active'            => true,
        ]);

        PatientData::create([
            'user_id'             => $user->id,
            'birthday'            => '1976-08-04',
            'region_id'           => '1',
            'post_code'           => '12345',
            'primary_phone'       => '123456789',
            'secondary_phone'     => '123456789',
            'accessible_mobility' => 1,
            'status'              => "inactive"
        ]);
    }
}
