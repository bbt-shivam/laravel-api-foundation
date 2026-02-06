<?php

namespace App\Services\RoleAndPermissions;

use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(array $validated){
        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'sanctum']);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return $role->load('permissions');
    }
}
