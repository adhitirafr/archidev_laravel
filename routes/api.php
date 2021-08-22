<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PortofolioController;
use App\Http\Controllers\API\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('category', [CategoryController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResource('/category', CategoryController::class);

    Route::apiResource('/portofolio', PortofolioController::class);

    Route::apiResource('/profile', ProfileController::class)->except([
        'destroy'
    ]);
});