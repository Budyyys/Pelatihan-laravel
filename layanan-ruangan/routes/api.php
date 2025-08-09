<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\API\AuthController;

// Public Auth Routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected Auth Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/revoke-all', [AuthController::class, 'revokeAllTokens']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Additional routes (define before apiResource)
Route::get('rooms/search', [RoomController::class, 'search']);
Route::get('rooms/statistics', [RoomController::class, 'statistics']);
Route::post('rooms/test-store', [RoomController::class, 'testStore']);

// CRUD routes untuk rooms
Route::apiResource('rooms', RoomController::class);
