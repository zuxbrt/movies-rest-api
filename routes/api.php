<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MoviesController;
use App\Http\Controllers\API\User\FavoritesController;
use App\Http\Controllers\API\User\FollowingController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth-api'], function(){

    Route::group(['prefix' => 'movies'], function(){
        Route::get('/', [MoviesController::class, 'movies']);
        Route::post('/', [MoviesController::class, 'addMovie']);
        Route::put('/', [MoviesController::class, 'updateMovie']);
        Route::delete('/', [MoviesController::class, 'deleteMovie']);
    });

    Route::group(['prefix' => 'favorites'], function(){
        Route::get('/', [FavoritesController::class, 'favorites']);
        Route::post('/', [FavoritesController::class, 'add']);
        Route::delete('/', [FavoritesController::class, 'remove']);
    });

    Route::group(['prefix' => 'following'], function(){
        Route::get('/', [FollowingController::class, 'following']);
        Route::post('/', [FollowingController::class, 'follow']);
        Route::delete('/', [FollowingController::class, 'unfollow']);
    });
});

