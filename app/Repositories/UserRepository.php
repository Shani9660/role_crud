<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(): LengthAwarePaginator
    {
        return User::latest()->paginate(10);
    }

    public function createUser(array $data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password']; 
        $user->save();
        
        return $user;
    }

    public function getUserById(string $id): ?User
    {
        return User::find($id);
    }

    public function updateUser(User $user, array $data): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();
        
        return $user;
    }

    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
}
