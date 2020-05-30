<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public $permissionsToSeed = [
        'View Dashboard',
        'View Permissions',
        'Edit Permissions',
        'View All Profiles'
    ];

    public $rolesToSeed = [
        'Super-Admin'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($this->permissionsToSeed as $permission) {
            try {
                Permission::create(['name' => $permission, 'guard_name' => 'web']);
                Permission::create(['name' => $permission, 'guard_name' => 'api']);
            } catch (Exception $exception) {
                // Permission Already Exists
            }
        }

        foreach ($this->rolesToSeed as $role) {
            try {
                Role::create(['name' => $role, 'guard_name' => 'web']);
                Role::create(['name' => $role, 'guard_name' => 'api']);
            } catch (Exception $exception) {
                // Role Already Exists
            }
        }
    }
}
