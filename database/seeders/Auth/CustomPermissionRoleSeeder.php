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
            ['id' => 30, 'name' => 'settings', 'description' => 'Διαχείριση Ρυθμίσεων'],
            [
                ['id' => 31, 'name' => 'settings.view', 'description' => 'Προβολή ρυθμίσεων διαχειριστή'],
                ['id' => 32, 'name' => 'settings.create', 'description' => 'Δημιουργία ρύθμισης διαχειριστή', 'sort' => 2],
                ['id' => 33, 'name' => 'settings.update', 'description' => 'Επεξεργασία ρύθμισης διαχειριστή', 'sort' => 3],
                ['id' => 34, 'name' => 'settings.delete', 'description' => 'Διαγραφή ρύθμισης διαχειριστή', 'sort' => 4],
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
