<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

$app = Illuminate\Foundation\Application::configure(basePath: __DIR__)
    ->create();

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\RoomService;

echo "=== ROOM SERVICE API TEST ===" . PHP_EOL;
echo "API URL: " . env('ROOM_SERVICE_API_URL') . PHP_EOL;
echo "Token: " . substr(env('ROOM_SERVICE_TOKEN'), 0, 20) . "..." . PHP_EOL;
echo PHP_EOL;

try {
    $roomService = new RoomService();
    $rooms = $roomService->getAllRooms();
    
    echo "Rooms found: " . count($rooms) . PHP_EOL;
    
    if (!empty($rooms)) {
        echo PHP_EOL . "=== ROOMS DATA ===" . PHP_EOL;
        foreach ($rooms as $index => $room) {
            echo ($index + 1) . ". " . $room['name'] . 
                 " (ID: " . $room['id'] . 
                 ", Capacity: " . $room['capacity'] . ")" . PHP_EOL;
        }
        echo PHP_EOL . "✅ API Connection Successful!" . PHP_EOL;
    } else {
        echo "❌ No rooms found or API connection failed." . PHP_EOL;
        echo "Please check:" . PHP_EOL;
        echo "1. layanan-ruangan service is running" . PHP_EOL;
        echo "2. API token is valid" . PHP_EOL;
        echo "3. Network connectivity" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== END TEST ===" . PHP_EOL;
