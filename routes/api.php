<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\ScreeningController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['namespace' => 'api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::get('auth_failed', function () {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    })->name('auth_failed');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('logout', [AuthenticationController::class, 'destroy']);

        Route::get('movies', [MovieController::class, 'index']);
        Route::post('movie', [MovieController::class, 'store']);
        Route::get('movie/{id}', [MovieController::class, 'show']);
        Route::get('movie/edit/{id}', [MovieController::class, 'edit']);
        Route::put('movie/{id}', [MovieController::class, 'update']);
        Route::delete('movie/{id}', [MovieController::class, 'destroy']);

        Route::get('screenings', [ScreeningController::class, 'index']);
        Route::get('movie/{id}/screenings', [ScreeningController::class, 'showScreeningsByMovie']);
        Route::post('screening', [ScreeningController::class, 'store']);
        Route::get('screening/{id}', [ScreeningController::class, 'show']);
        Route::get('screening/edit/{id}', [ScreeningController::class, 'edit']);
        Route::put('screening/{id}', [ScreeningController::class, 'update']);
        Route::delete('screening/{id}', [ScreeningController::class, 'destroy']);
    });
});