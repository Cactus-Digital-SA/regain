<?php

declare(strict_types = 1);

namespace Database\Seeders\Auth;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
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

        User::create([
            'name'              => 'patient',
            'email'             => 'patient@regain',
            'password'          => bcrypt('123456'),
            'email_verified_at' => now(),
            'active'            => true,
        ]);
    }
}
