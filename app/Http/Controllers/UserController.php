<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
         return[
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:delete users', only: ['destroy']),

         ];
    }
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAllUsers();
        return view('users.list', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name','ASC')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validation->fails()) {
            return redirect()->route('users.create')->withInput()->withErrors($validation);
        }

        $userData = $request->only(['name', 'email']);
        $userData['password'] = Hash::make($request->password);

        $user = $this->userRepository->createUser($userData);

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User added successfully');
    }

    public function edit(string $id)
    {
        $user = $this->userRepository->getUserById($id);
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasroles = $user->roles->pluck('id');

        return view('users.edit', compact('user', 'roles', 'hasroles'));
    }

    public function update(Request $request, string $id)
    {
        $user = $this->userRepository->getUserById($id);

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
        ]);

        if ($validation->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validation);
        }

        $userData = $request->only(['name', 'email']);
        $user = $this->userRepository->updateUser($user, $userData);

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = $this->userRepository->getUserById($id);

        if ($user === null) {
            session()->flash('error', 'User not found');
            return response()->json(['status' => false]);
        }

        $this->userRepository->deleteUser($user);

        session()->flash('success', 'User deleted successfully');
        return response()->json(['status' => true]);
    }
}




