<?php

use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\AuthController;
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

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middlware' => ['api'], 'namespace' => 'api'], function () {
        Route::group(['prefix' => 'admin'], function(){
            Route::post('login', [AuthController::class, 'login'])->name('login');
            // Route::post('logout', [AuthController::class, 'logout'])->middleware('admintoken:admin_token');
        });
    });

    // Clients
    Route::group(['middlware' => ['api'], 'namespace' => 'api'], function () {
        Route::group(['prefix' => 'jwtclients'], function(){
            Route::post('login', [AuthClientController::class, 'login'])->name('login');
            // Route::post('logout', [AuthClientController::class, 'logout'])->middleware('admintoken:admin_token');
        });
    });
