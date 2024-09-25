<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Book\BookController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Permission\PermissionController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth/v1')->group(function (){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('current', [AuthController::class, 'current']);
});

Route::prefix('v1')->group(function (){
    Route::apiResource('roles', RoleController::class);
});

Route::prefix('v1')->group(function (){
    Route::apiResource('permissions', PermissionController::class);
    Route::post('permission/{id}/restore', [PermissionController::class, 'restore']);
    Route::get('deleted/permissions', [PermissionController::class, 'getDeletedPermissions']);
    Route::delete('permission/{id}/permanently/delete', [PermissionController::class, 'forceDelete']);
});

Route::prefix('v1')->group(function (){
    Route::apiResource('users', UserController::class);
    Route::post('user/{user}/assign/roles', [UserController::class, 'assignRoles']);
    Route::post('user/{id}/restore', [UserController::class, 'restore']);
    Route::get('deleted/users', [UserController::class, 'getDeletedUsers']);
    Route::delete('user/{id}/permanently/delete', [UserController::class, 'forceDelete']);
});

Route::prefix('v1')->group(function (){
    Route::apiResource('categories', CategoryController::class);
    Route::post('category/{id}/restore', [CategoryController::class, 'restore']);
    Route::get('deleted/categories', [CategoryController::class, 'getDeletedCategories']);
    Route::delete('category/{id}/permanently/delete', [CategoryController::class, 'forceDelete']);
});

Route::prefix('v1')->group(function (){
    Route::apiResource('books', BookController::class);
    Route::post('book/{id}/restore', [BookController::class, 'restore']);
    Route::get('deleted/books', [BookController::class, 'getDeletedBooks']);
    Route::delete('book/{id}/permanently/delete', [BookController::class, 'forceDelete']);
});
