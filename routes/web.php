<?php

use App\Http\Controllers\Admin\CompleteTaskController;
use App\Http\Controllers\Auth\Employee\LoginController;
use App\Http\Controllers\Employee\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::redirect('/', 'admin/dashboard');

Route::redirect('/dashboard', 'admin/dashboard');

Route::prefix('employee')
    ->name('employee.')
    ->group(function () {

        Route::middleware('guest')->group(function () {
            Route::get('login', [LoginController::class, 'create'])
                ->name('login');
            Route::post('login', [LoginController::class, 'authenticate'])->name('login');
        });

        Route::middleware('auth:employee')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::put('tasks/{task}/complete', CompleteTaskController::class)->middleware('role:employee')->name('tasks.complete');

            Route::post('logout', [LoginController::class, 'destroy'])
                ->name('logout');

        });
    });
