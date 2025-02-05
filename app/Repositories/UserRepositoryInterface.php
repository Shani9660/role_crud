<?php 
namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAllUsers(): LengthAwarePaginator;

    public function createUser(array $data): User;

    public function getUserById(string $id): ?User;

    public function updateUser(User $user, array $data): User;

    public function deleteUser(User $user): bool;
}
