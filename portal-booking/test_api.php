<?php

/**
 * Test API Connection Script
 * Run this script to test the Room Service API connection with the generated token
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$baseUrl = $_ENV['ROOM_SERVICE_API_URL'] ?? 'http://localhost:8081/api';
$token = $_ENV['ROOM_SERVICE_TOKEN'] ?? '';

if (empty($token)) {
    echo "❌ ERROR: ROOM_SERVICE_TOKEN not found in .env file\n";
    exit(1);
}

echo "🔧 Testing Room Service API Connection\n";
echo "📍 Base URL: {$baseUrl}\n";
echo "🔑 Token: " . substr($token, 0, 10) . "...\n\n";

// Test 1: Get all rooms
echo "🧪 Test 1: GET /rooms\n";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $baseUrl . '/rooms',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
        'Accept: application/json'
    ]
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "❌ Connection Error: {$error}\n";
} else {
    echo "📋 HTTP Status: {$httpCode}\n";
    echo "📄 Response: " . (strlen($response) > 200 ? substr($response, 0, 200) . '...' : $response) . "\n";
    
    if ($httpCode === 200) {
        echo "✅ API Connection Successful!\n";
        
        // Parse and display room data
        $data = json_decode($response, true);
        if (isset($data['data']) && is_array($data['data'])) {
            echo "🏠 Found " . count($data['data']) . " rooms\n";
            foreach ($data['data'] as $index => $room) {
                echo "   Room " . ($index + 1) . ": {$room['name']} (Capacity: {$room['capacity']})\n";
            }
        }
    } else {
        echo "⚠️  API returned non-200 status\n";
    }
}

echo "\n";

// Test 2: Try to create a test room
echo "🧪 Test 2: POST /rooms (Create test room)\n";
$testRoomData = [
    'name' => 'Test Room API',
    'capacity' => 10,
    'description' => 'Test room created via API',
    'location' => 'Test Building',
    'facilities' => ['WiFi', 'Projector']
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $baseUrl . '/rooms',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($testRoomData),
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
        'Accept: application/json'
    ]
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "❌ Connection Error: {$error}\n";
} else {
    echo "📋 HTTP Status: {$httpCode}\n";
    echo "📄 Response: " . (strlen($response) > 200 ? substr($response, 0, 200) . '...' : $response) . "\n";
    
    if ($httpCode === 201 || $httpCode === 200) {
        echo "✅ Room Creation Successful!\n";
        
        // Store the created room ID for cleanup
        $data = json_decode($response, true);
        if (isset($data['data']['id'])) {
            $createdRoomId = $data['data']['id'];
            echo "🆔 Created Room ID: {$createdRoomId}\n";
            
            // Test 3: Delete the test room
            echo "\n🧪 Test 3: DELETE /rooms/{$createdRoomId} (Cleanup)\n";
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $baseUrl . "/rooms/{$createdRoomId}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json',
                    'Accept: application/json'
                ]
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                echo "❌ Connection Error: {$error}\n";
            } else {
                echo "📋 HTTP Status: {$httpCode}\n";
                if ($httpCode === 200 || $httpCode === 204) {
                    echo "✅ Room Deletion Successful!\n";
                } else {
                    echo "⚠️  Failed to delete test room\n";
                }
            }
        }
    } else {
        echo "⚠️  Room creation failed\n";
    }
}

echo "\n=== API Test Complete ===\n";

// Check token abilities
echo "\n🔍 Token Information:\n";
echo "🎯 Token Abilities: room:read, room:write, room:delete\n";
echo "👤 Token User: Room Service Admin\n";
echo "📧 Email: admin@room-service.com\n";
echo "⏰ Token Generated: " . date('Y-m-d H:i:s') . "\n";

echo "\n💡 Usage Examples:\n";
echo "   - GET {$baseUrl}/rooms (List all rooms)\n";
echo "   - GET {$baseUrl}/rooms/{id} (Get specific room)\n";
echo "   - POST {$baseUrl}/rooms (Create new room)\n";
echo "   - PUT {$baseUrl}/rooms/{id} (Update room)\n";
echo "   - DELETE {$baseUrl}/rooms/{id} (Delete room)\n";
echo "\n🔑 Always include: Authorization: Bearer {token}\n";
