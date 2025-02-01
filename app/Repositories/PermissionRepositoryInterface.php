<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    public function getAllPermissions();
    public function createPermission(array $data);
    public function getPermissionById(string $id);
    public function updatePermission(Permission $permission, array $data);
    public function deletePermission(Permission $permission);
}
