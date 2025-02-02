<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\RolesRepositoryInterface;
use App\Repositories\RolesRepository;


class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RolesRepositoryInterface::class, RolesRepository::class);
    }

    
    public function boot(): void
    {
        //
    }
}
