<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Repositories\Eloquent\Models\Permission;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'id' => 1,
            'name' => 'admin.access.user',
            'description' => 'All User Rights',
        ]);

        $users->children()->saveMany([
            new Permission([
                'id' => 2,
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'id' => 3,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'id' => 4,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Re-Activate Users',
                'sort' => 3,
            ]),
            new Permission([
                'id' => 5,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear Session of User',
                'sort' => 4,
            ]),
            new Permission([
                'id' => 6,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Login as User',
                'sort' => 5,
            ]),
            new Permission([
                'id' => 7,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Password',
                'sort' => 6,
            ]),
            new Permission([
                'id' => 8,
                'name' => 'admin.access.user.create',
                'description' => 'Create User',
                'sort' => 7,
            ]),
            new Permission([
                'id' => 9,
                'name' => 'admin.access.user.edit',
                'description' => 'Edit User',
                'sort' => 8,
            ]),
            new Permission([
                'id' => 10,
                'name' => 'admin.access.user.show',
                'description' => 'View User',
                'sort' => 9,
            ]),
            new Permission([
                'id' => 11,
                'name' => 'admin.access.user.delete',
                'description' => 'Delete User',
                'sort' => 10,
            ]),
        ]);

        Permission::create([
            'id' => 20,
            'name' => 'edit permissions' ,
            'description' => 'Edit Rights'
        ]);
        Permission::create([
            'id' => 21,
            'name' => 'crud roles' ,
            'description' => 'Crud Roles'
        ]);
        Permission::create([
            'id' => 22,
            'name' => 'view logs' ,
            'description' => 'View Logs'
        ]);


        $this->enableForeignKeys();

        $role = Role::findById(RolesEnum::SuperAdmin->value);
        $role->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $role=Role::findById(RolesEnum::Administrator->value);
        $role->syncPermissions(\Spatie\Permission\Models\Permission::all());
    }
}
