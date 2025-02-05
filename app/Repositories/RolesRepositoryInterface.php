<?php 

namespace App\Repositories;

use Illuminate\Http\Request;

interface RolesRepositoryInterface
{
    public function index(int $perPage);
    
    public function getPermissions();
    
    public function create(Request $request);
    
    public function edit(string $id);
    
    public function update(Request $request, string $id);
    
    public function destroy(string $id);
}