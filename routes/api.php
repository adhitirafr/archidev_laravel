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
Route::get('category/{category}', [CategoryController::class, 'show']);

Route::get('portofolio', [PortofolioController::class, 'index']);
Route::get('portofolio/{portofolio}', [PortofolioController::class, 'show']);

Route::get('/profile', [ProfileController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    
    Route::apiResource('/category', CategoryController::class)->except([
        'index', 'show'
    ]);

    Route::apiResource('/portofolio', PortofolioController::class)->except([
        'index', 'show'
    ]);

    Route::post('/profile', [ProfileController::class, 'store']);
});