<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesRepository implements RolesRepositoryInterface
{
    public function index(int $perPage)
    {
        return Role::orderBy('name', 'ASC')->paginate($perPage);
    }
    
    public function create(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        
        if ($validator->fails()) {
            return $validator;
        }

       
        $role = Role::create(['name' => $request->name]);

       
        if (!empty($request->permission)) {
            foreach ($request->permission as $name) {
                $role->givePermissionTo($name);
            }
        }

        return $role;
    }

    public function edit(string $id)
    {
        return Role::findById($id);
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findById($id);

        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id'
        ]);

        
        if ($validator->fails()) {
            return $validator;
        }

        
        $role->name = $request->name;
        $role->save();

        if (!empty($request->permission)) {
            $role->syncPermissions($request->permission);
        } else {
            $role->syncPermissions([]);
        }

        return $role;
    }

    public function destroy(string $id)
    {
        $role = Role::findById($id);
        if ($role !== null) {
            $role->delete();
            return true;
        }
        return false;
    }

    public function getPermissions()
    {
        return Permission::orderBy('name', 'ASC')->get();
    }
}
