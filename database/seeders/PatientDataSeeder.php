<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Patient\Repositories\Eloquent\Models\PatientData;
use Illuminate\Database\Seeder;

class PatientDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::create([
            'name'              => 'patient',
            'email'             => 'patient@regain',
            'password'          => bcrypt('123456'),
            'email_verified_at' => now(),
            'active'            => true,
        ]);
    }
}
