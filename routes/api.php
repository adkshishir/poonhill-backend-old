<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OwnTripController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\ParentActivityController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ViewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// user auth
Route::post('/register', [UserController::class, 'registration']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/reset-password/{token}', [UserController::class, 'resetPassword']);
Route::post('/forgot-password', [UserController::class, 'forgetPassword']);

// package
Route::get('/package', [PackageController::class, 'index']);
Route::get('/package/{title}', [PackageController::class, 'show']);
// parent activity
Route::get('/parent-activity', [ParentActivityController::class, 'index']);
Route::get('/parent-activity/{title}', [ParentActivityController::class, 'show']);
// destination
Route::get('/destination', [DestinationController::class, 'index']);
Route::get('/destination/{id}', [DestinationController::class, 'show']);
// activity
Route::get('/activity', [ActivityController::class, 'index']);
Route::get('/activity/{id}', [ActivityController::class, 'show']);
// Menu items
Route::get('/menu-items-parent', [MenuController::class, 'parent_activity']);
Route::get('/menu', [MenuController::class, 'parent_activity']);
Route::get('/menu-items-destination/{id}', [MenuController::class, 'destination']);
// search
Route::get('/search', [MenuController::class, 'search']);
// update views
Route::post("/views", [ViewsController::class, "store"]);
//   booking
Route::post('/book-newuser',[BookingController::class,'newUserBook']);
// own trip
Route::post('/owntrip-by-guest',[OwnTripController::class, 'sendOwnTripByGuest']);
// Contact us
Route::post('/contact',[ContactController::class, 'store']);
Route::get('/contact', [ContactController::class, 'index']);



Route::middleware('auth:api')->group(function () {
    // package
    Route::post('/package', [PackageController::class, 'store']);
    Route::put('/package/{id}', [PackageController::class, 'update']);
    Route::delete('/package/{id}', [PackageController::class, 'destroy']);
    // destination
    Route::post('/destination', [DestinationController::class, 'store']);
    Route::put('/destination/{id}', [DestinationController::class, 'update']);
    Route::delete('/destination/{id}', [DestinationController::class, 'destroy']);
    // parent activity
    Route::post('/parent-activity', [ParentActivityController::class, 'store']);
    Route::put('/parent-activity/{id}', [ParentActivityController::class, 'update']);
    Route::delete('/parent-activity/{id}', [ParentActivityController::class, 'destroy']);
    // activity
    Route::post('/activity', [ActivityController::class, 'store']);
    Route::put('/activity/{id}', [ActivityController::class, 'update']);
    Route::delete('/activity/{id}', [ActivityController::class, 'destroy']);
    // Image
    Route::post('/image', [ImageController::class, 'store']);
    Route::delete('/image/{id}', [ImageController::class, 'destroy']);
    Route::get('/image/{id}', [ImageController::class, 'show']);
    Route::get('/image', [ImageController::class, 'index']);
    // see Views
    Route::get('/views', [ViewsController::class, 'index']);
    //    booking
    Route::get('/booking', [BookingController::class, 'index']);
   Route::post('/book-olduser',[BookingController::class,'oldUserBook']);
   Route::delete('/booking/{id}', [BookingController::class, 'destroy']);
   Route::get('/booking/{id}', [BookingController::class, 'show']);

    // own trip
    Route::post('/owntrip-by-user',[OwnTripController::class, 'sendOwnTripByUser']);
    
    // check admin
    Route::get('/check-admin',[UserController::class,'checkAdmin']);

    
});