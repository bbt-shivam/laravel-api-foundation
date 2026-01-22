<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        try {
            return $this->success(['roles' => Role::with('permissions')->get()]);
        } catch (\Exception $e){
            // throw $e;
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name, "guard_name" => 'sanctum']);

        if($request->permissions){
            $role->syncPermissions($request->permissions);
        }

        return $this->success($role->load('permissions'), "Role created.");
    }

    public function show(Role $role)
    {
        return $this->success($role->load('permissions'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => "required|unique:roles,name," . $role->id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->name]);

        if($request->permissions){
            $role->syncPermissions($request->permissions);
        }

        return $this->success(['role' => $role->load('permissions')], "Role updated.");
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return $this->success(null, "Role deleted");
    }
}
