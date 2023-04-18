<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UserController;
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
//Routes for admins
Route::group(['middleware' => []], function () {
        Route::post('/registration', [AuthController::class, 'registration'])->name('registration');
});


//Routes for editors or admins
Route::group(['middleware' => ['auth:sanctum', 'editor']], function () {
    Route::post('/buildings', [BuildingController::class, 'store'])->name('store_building');
});


//Routs for auth users
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResources([
        'users' => UserController::class
    ]);

    Route::get('/buildings', [BuildingController::class, 'index'])->name('get_building');
    Route::patch('/users/sync/buildings', [UserController::class, 'sync_buildings'])->name('sync_buildings');

});


//Routes for guests
Route::group(['middleware' => ['guest']], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
