<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    
    public function index()
    {
        $permissions = $this->permissionRepository->getAllPermissions();
        return view('permission.list', [
            'permissions' => $permissions
        ]);
    }

    
    public function create()
    {
        return view('permission.create');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->passes()) {
            $this->permissionRepository->createPermission(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission added successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    
    public function edit(string $id)
    {
        $permissions = $this->permissionRepository->getPermissionById($id);
        return view('permission.edit', [
            'permissions' => $permissions
        ]);
    }

    
    public function update(Request $request, string $id)
    {
        $permissions = $this->permissionRepository->getPermissionById($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $id . ',id',
        ]);

        if ($validator->passes()) {
            $this->permissionRepository->updatePermission($permissions, ['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
        } else {
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

   
    public function destroy(Request $request)
    {
        $permissions = $this->permissionRepository->getPermissionById($request->id);

        if ($permissions === null) {
            session()->flash('error', 'Permission not found');
            return response()->json([
                'status' => false
            ]);
        }

        $this->permissionRepository->deletePermission($permissions);
        session()->flash('success', 'Permission deleted successfully');
        return response()->json([
            'status' => true
        ]);
    }
}
