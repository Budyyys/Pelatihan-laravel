<?php

use App\Services\RoomService;

Route::get('/test-rooms', function () {
    $roomService = new RoomService();
    $rooms = $roomService->getAllRooms();
    
    return response()->json([
        'api_url' => env('ROOM_SERVICE_API_URL'),
        'token_exists' => !empty(env('ROOM_SERVICE_TOKEN')),
        'token_preview' => substr(env('ROOM_SERVICE_TOKEN') ?? '', 0, 20) . '...',
        'rooms_count' => count($rooms),
        'rooms' => $rooms
    ]);
});
