<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Repositories\Eloquent\Models\Permission;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class CustomPermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Function to handle firstOrCreate for permissions
        function updateOrCreatePermissions($parentData, $childrenData): void
        {
            $parent = Permission::updateOrCreate([
                'id' => $parentData['id'],
            ], $parentData);

            $childrenPermissions = [];
            foreach ($childrenData as $child) {
                $childrenPermissions[] = Permission::updateOrCreate([
                    'id' => $child['id'],
                ], $child);
            }

            $parent->children()->saveMany($childrenPermissions);
        }

        // Settings permissions
        updateOrCreatePermissions(
            ['id' => 30, 'name' => 'settings', 'description' => 'Manage Settings'],
            [
                ['id' => 31, 'name' => 'settings.view', 'description' => 'View settings admin'],
                ['id' => 32, 'name' => 'settings.create', 'description' => 'Create settings admin', 'sort' => 2],
                ['id' => 33, 'name' => 'settings.update', 'description' => 'Edit settings admin', 'sort' => 3],
                ['id' => 34, 'name' => 'settings.delete', 'description' => 'Delete settings admin', 'sort' => 4],
            ]
        );

        updateOrCreatePermissions(
            ['id' => 35, 'name' => 'admin.tests', 'description' => 'Manage Tests'],
            [
                ['id' => 36, 'name' => 'admin.tests.view', 'description' => 'View Test'],
                ['id' => 37, 'name' => 'admin.tests.create', 'description' => 'Create Test', 'sort' => 2],
                ['id' => 38, 'name' => 'admin.tests.update', 'description' => 'Edit Test', 'sort' => 3],
                ['id' => 39, 'name' => 'admin.tests.delete', 'description' => 'Delete Test', 'sort' => 4],

                ['id' => 40, 'name' => 'admin.instructions.view', 'description' => 'View Instruction'],
                ['id' => 41, 'name' => 'admin.instructions.create', 'description' => 'Create Instruction'],
                ['id' => 42, 'name' => 'admin.instructions.update', 'description' => 'Edit Instruction'],
                ['id' => 43, 'name' => 'admin.instructions.delete', 'description' => 'Delete Instruction'],


            ]
        );



        // Assign Permissions to other Roles
        $this->enableForeignKeys();

        $role = Role::findByName('super-admin');
        $role->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $role=Role::findByName('Administrator','web');
        $role->syncPermissions(\Spatie\Permission\Models\Permission::all());
    }
}
