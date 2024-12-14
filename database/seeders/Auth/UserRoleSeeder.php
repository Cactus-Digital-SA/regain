<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
use App\Domains\Auth\Repositories\Eloquent\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $superAdminRole = Role::findById(RolesEnum::SuperAdmin->value);
        User::find(1)->assignRole($superAdminRole);

        $adminRole = Role::findById(RolesEnum::Administrator->value);
        User::find(2)->assignRole($adminRole);

        $practitionerRole = Role::findById(RolesEnum::Practitioner->value);
        User::find(3)->assignRole($practitionerRole);

        $patientRole = Role::findById(RolesEnum::Patient->value);
        User::find(4)->assignRole($patientRole);

        $this->enableForeignKeys();
    }
}
