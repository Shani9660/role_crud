<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionRepository implements PermissionRepositoryInterface
{
   
    public function getAllPermissions()
    {
        return Permission::orderBy('created_at', 'DESC')->paginate(5);
    }

    
    public function createPermission(array $data)
    {
        return Permission::create(['name' => $data['name']]);
    }

    
    public function getPermissionById(string $id)
    {
        return Permission::find($id);
    }

    
    public function updatePermission(Permission $permission, array $data)
    {
        $permission->name = $data['name'];
        return $permission->save();
    }

    
    public function deletePermission(Permission $permission)
    {
        return $permission->delete();
    }
}
