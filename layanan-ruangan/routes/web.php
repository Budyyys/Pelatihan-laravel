<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::get('/', [RoomController::class, 'webIndex']);
Route::get('/rooms', [RoomController::class, 'webIndex']);
