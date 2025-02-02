<?php

namespace App\Http\Controllers;

use App\Repositories\RolesRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
   
   
    public function index()
    {
        $roles = Role::orderBy('name','ASC')->paginate(1);
        return view('roles.list',[
            'roles' => $roles
        ]);
    }

   
    public function create()
    {
        $permission = Permission::orderBy('name','ASC')->get();
        return view('roles.create',[
            'permission' => $permission
        ]);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($validator->passes()) {
               $role =  Role::create(['name' => $request->name]);

                if(!empty($request->name)){
                    foreach($request->permission as $name){
                        $role->givePermissionTo($name);
                    }
                }
            return redirect()->route('roles.index')->with('success', 'Roles added successfully');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

   
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        $role = Role::findById($id);
        $RPermission = $role->permissions->pluck('name');
        $permission = Permission::orderBy('name','ASC')->get();
        
        
        return view('roles.edit',[
            'permission' => $permission,
            'RPermission' => $RPermission,
            'role' => $role
        ]);
    }

    
    public function update(Request $request, string $id)
    {
        $role = Role::findById($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id.',id'
        ]);

        if ($validator->passes()) {
              $role->name = $request->name;
              $role->save();

                if(!empty($request->permission)){
                    $role->syncPermissions($request->permission);
                }else{
                    $role->syncPermissions([]);
                }
            return redirect()->route('roles.index')->with('success', 'Roles Updated successfully');
        } else {
            return redirect()->route('roles.edit,$id')->withInput()->withErrors($validator);
        }
        
    }

    
    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::findById($id);
        
        if ($role === null) {
            session()->flash('error', 'role not found');
            return response()->json([
                'status' => false
            ]);
        }
        $role->delete();
        session()->flash('success', 'role delete successfully');
        return response()->json([
            'status' => true
        ]);
    }
}
