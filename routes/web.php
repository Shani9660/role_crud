<?php

use App\Http\Controllers\ArticalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permission Route ///
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/{id}/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Roles routes //
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/{id}/update', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles', [RolesController::class, 'destroy'])->name('roles.destroy');

 // Artical Routes //
    Route::get('/articals/create', [ArticalController::class, 'create'])->name('articals.create');
    Route::get('/articals', [ArticalController::class, 'index'])->name('articals.index');
    Route::post('/articals', [ArticalController::class, 'store'])->name('articals.store');
    Route::get('/articals/{id}/edit', [ArticalController::class, 'edit'])->name('articals.edit');
    Route::post('/articals/{id}/update', [ArticalController::class, 'update'])->name('articals.update');
    Route::delete('/articals', [ArticalController::class, 'destroy'])->name('articals.destroy');

// User Route //
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');
    
});

require __DIR__.'/auth.php';
