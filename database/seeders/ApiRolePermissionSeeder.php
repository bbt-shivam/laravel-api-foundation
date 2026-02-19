<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ApiRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'sanctum';

        $permissions = [

            // Roles
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',

            // Permissions
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',

            // Settings
            'settings.view',
            'settings.contact.update',
            'settings.copyright.update',
            'settings.logo.update',
            'settings.maintenance.update',

            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
                'is_system' => true,
            ]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => $guard,
            'is_system' => true,
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $guard,
            'is_system' => true,
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => $guard,
            'is_system' => true,
        ]);

        $allPermissions = Permission::pluck('name')->toArray();

        $superAdmin->givePermissionTo($allPermissions);

        $admin->syncPermissions([
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',

            'settings.view',
            'settings.contact.update',
            'settings.copyright.update',
            'settings.logo.update',
            'settings.maintenance.update',

            'users.view',
            'users.create',
            'users.update',
            'users.delete',
        ]);
    }
}
