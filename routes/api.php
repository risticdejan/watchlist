<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\WatchlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/watchlist', [WatchlistController::class, 'store']);
    Route::get('/watchlist', [WatchlistController::class, 'index']);
    Route::get('/watchlist/{id}', [WatchlistController::class, 'show']);
    Route::delete('/watchlist/{id}', [WatchlistController::class, 'destroy']);
    Route::patch('/watchlist/{id}', [WatchlistController::class, 'update']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
    ]);
});
