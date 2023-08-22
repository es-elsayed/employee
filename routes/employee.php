<?php

use App\Http\Controllers\Admin\TaskController;
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

Route::group(['prefix' => 'employee'], function () {
    Route::resource('tasks', TaskController::class);
});
