<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Roles\DeleteRoleRequest;
use App\Http\Requests\Api\V1\Roles\StoreRoleRequest;
use App\Services\RoleAndPermissions\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        try {
            return $this->success(['roles' => Role::with('permissions')->get()]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function store(StoreRoleRequest $request, RoleService $roleService)
    {
        $role = $roleService->store($request->validated());
        return $this->success($role, 'Role created.');
    }

    public function show(Role $role)
    {
        return $this->success($role->load('permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return $this->success(['role' => $role->load('permissions')], 'Role updated.');
    }

    public function destroy(DeleteRoleRequest $request, Role $role)
    {
        $role->delete();
        return $this->success(null, 'Role deleted');
    }
}
