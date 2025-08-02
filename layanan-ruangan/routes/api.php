<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Additional routes (define before apiResource)
Route::get('rooms/search', [RoomController::class, 'search']);
Route::get('rooms/statistics', [RoomController::class, 'statistics']);

// CRUD routes untuk rooms
Route::apiResource('rooms', RoomController::class);
