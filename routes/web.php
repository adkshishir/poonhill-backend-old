<?php

use App\Http\Controllers\Api\ParentActivityController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'admin'], function () {
    Route::resource('parent-activity', ParentActivityController::class)->names([
        'view' => 'parent-activity.view',
        'create' => 'parent-activity.create',
        'store' => 'parent-activity.store',
        'edit' => 'parent-activity.edit',
        'update' => 'parent-activity.update',
        'destroy' => 'parent-activity.destroy',
        'show' => 'parent-activity.show'
    ]);
});