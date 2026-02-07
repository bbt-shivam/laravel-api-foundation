<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ApiRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            'access-roles',
            'create-role',
            'edit-role',
            'delete-role',
            'access-permission',
            'create-permission',
            'edit-permmission',
            'delete-permission',

            'access-settings',
            'edit-setting-contact-details',
            'edit-setting-copyright-text',
            'edit-logo',
            'edit-setting-maintenance',

            'access-users',
            'create-user',
            'edit-user',
            'list-user',
            'delete-user',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'sanctum']
            );
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'sanctum']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'sanctum']);
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'sanctum']);

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());
        $user->givePermissionTo('partial-edit-member');
    }
}
