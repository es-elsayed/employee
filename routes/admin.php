<?php

use App\Http\Controllers\Admin\CompleteTaskController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionRoleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "auth" middleware group. Now create something great!
|
 */

Route::group(['middleware' => 'verified'], function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('roles', RoleController::class);
    Route::post('permissions/{permission}/role', PermissionRoleController::class)->name('roles.permission')->middleware("can:roles-update");
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::put('tasks/{task}/complete', CompleteTaskController::class)->middleware('can:tasks-update')->name('tasks.complete');
    Route::resource('tasks', TaskController::class);
});
