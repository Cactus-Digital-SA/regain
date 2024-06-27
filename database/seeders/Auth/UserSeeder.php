<?php

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
    public function run()
    {
        // Add the master administrator, user id of 1
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@cactusweb.gr',
            'password' => bcrypt('123456'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

        User::create([
            'name' => 'Cactus',
            'email' => 'dimitris@cactusweb.gr',
            'password' => bcrypt('1425lx36'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

    }
}
