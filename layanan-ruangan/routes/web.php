<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::get('/', [RoomController::class, 'webIndex']);
Route::get('/rooms', [RoomController::class, 'webIndex']);

// Swagger Documentation - Simple HTML page
Route::get('/api/documentation', function () {
    $swaggerJsonUrl = url('/docs');
    return response(view('swagger-ui', compact('swaggerJsonUrl')));
});
