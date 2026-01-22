<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ApiRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-member',
            'edit-member',
            'partial-edit-member',
            'delete-member',
            'list-deleted-member',
            'restore-deleted-member',
            'list-member',

            'settings',
            'general-setting',
            'edit-setting-contact-details',
            'edit-setting-copyright-text',
            'edit-logo',
            'edit-setting-social-links',
            'edit-setting-maintenance',

            'create-operator',
            'edit-operator',
            'list-operator',
            'delete-operator',

            'create-donation-purpose',
            'edit-donation-purpose',
            'list-donation-purpose',
            'delete-donation-purpose',

            'list-quick-qr',
            'create-quick-qr',
            'print-quick-qr',
            'delete-quick-qr',

            'daily-report-pdf',
            'daily-report-excel',
            'range-report-pdf',
            'range-report-excel',
            'pending-report-pdf',
            'pending-report-excel',
            'state-report-pdf',
            'state-report-excel',
            'member-report-pdf',
            'member-report-excel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'sanctum']
            );
        }

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'sanctum']);
        $officeAdminRole = Role::create(['name' => 'office-admin', 'guard_name' => 'sanctum']);
        $operatorRole  = Role::create(['name' => 'operator', 'guard_name' => 'sanctum']);

        $adminRole->givePermissionTo(Permission::all());
        $officeAdminRole->givePermissionTo(Permission::all());
        $operatorRole->givePermissionTo('partial-edit-member');
    }
}
