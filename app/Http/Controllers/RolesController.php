<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RolesRepositoryInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RolesController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
         return[
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:destory roles', only: ['destroy']),

         ];
    }
    protected $rolesRepository;

    public function __construct(RolesRepositoryInterface $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }

    public function index()
    {
        $roles = $this->rolesRepository->index(10);
        return view('roles.list', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = $this->rolesRepository->getPermissions();
        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $role = $this->rolesRepository->create($request);

        if ($role instanceof \Illuminate\Support\Facades\Validator) {
            return redirect()->route('roles.create')->withInput()->withErrors($role);
        }

        return redirect()->route('roles.index')->with('success', 'Role added successfully');
    }

    public function edit(string $id)
    {
        $role = $this->rolesRepository->edit($id);
        $permissions = $this->rolesRepository->getPermissions();
        $rolePermissions = $role->permissions->pluck('name');

        return view('roles.edit', [
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
            'role' => $role
        ]);
    }

    public function update(Request $request, string $id)
    {
        $role = $this->rolesRepository->update($request, $id);

        if ($role instanceof \Illuminate\Support\Facades\Validator) {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($role);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Request $request)
    {
        $deleted = $this->rolesRepository->destroy($request->id);

        if ($deleted) {
            session()->flash('success', 'Role deleted successfully');
            return response()->json(['status' => true]);
        } else {
            session()->flash('error', 'Role not found');
            return response()->json(['status' => false]);
        }
    }
}




