<?php 

namespace App\Repositories;

use Illuminate\Http\Request;

interface ArticalRepositoryInterface
{
    public function index(int $perPage);
    
    public function create(Request $request);
    
    public function edit(string $id);
    
    public function update(Request $request, string $id);
    
    public function destroy(string $id);
}