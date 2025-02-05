<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\RolesRepositoryInterface;
use App\Repositories\RolesRepository;
use App\Repositories\ArticalRepositoryInterface;
use App\Repositories\ArticalRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;



class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RolesRepositoryInterface::class, RolesRepository::class);
        $this->app->bind(ArticalRepositoryInterface::class, ArticalRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    
    public function boot(): void
    {
        //
    }
}
