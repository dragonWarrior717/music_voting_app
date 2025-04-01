<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AlbumController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Album routes
    Route::get('/albums', [AlbumController::class, 'index']);
    Route::post('/albums', [AlbumController::class, 'store']);
    Route::get('/albums/{album}', [AlbumController::class, 'show']);
    Route::put('/albums/{album}', [AlbumController::class, 'update']);
    Route::post('/albums/{album}/vote', [AlbumController::class, 'vote']);
    
    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::delete('/albums/{album}', [AlbumController::class, 'destroy']);
    });
}); 