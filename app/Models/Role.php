<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends Model
{
    

    protected $fillable = [
        'name',
        'guard_name',
        
    ];

    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
