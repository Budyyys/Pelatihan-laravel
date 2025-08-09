<?php

// Simple API Test without Laravel Bootstrap
echo "=== SIMPLE ROOM SERVICE API TEST ===" . PHP_EOL;

// Load environment variables
if (file_exists(__DIR__ . '/.env')) {
    $env = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env as $line) {
        if (strpos($line, '=') !== false && !str_starts_with($line, '#')) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

$apiUrl = $_ENV['ROOM_SERVICE_API_URL'] ?? 'http://localhost:8081/api';
$token = $_ENV['ROOM_SERVICE_TOKEN'] ?? '';

echo "API URL: " . $apiUrl . PHP_EOL;
echo "Token: " . substr($token, 0, 20) . "..." . PHP_EOL;
echo PHP_EOL;

if (empty($token)) {
    echo "❌ ERROR: ROOM_SERVICE_TOKEN not found in .env file" . PHP_EOL;
    exit(1);
}

// Test API connection using cURL
echo "🧪 Testing API connection..." . PHP_EOL;

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl . '/rooms',
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
    echo "❌ Connection Error: " . $error . PHP_EOL;
    echo "💡 Make sure layanan-ruangan service is running" . PHP_EOL;
} else {
    echo "📋 HTTP Status: " . $httpCode . PHP_EOL;
    
    if ($httpCode === 200) {
        echo "✅ API Connection Successful!" . PHP_EOL;
        
        $data = json_decode($response, true);
        if (isset($data['data']) && is_array($data['data'])) {
            echo "🏠 Found " . count($data['data']) . " rooms:" . PHP_EOL;
            foreach ($data['data'] as $index => $room) {
                echo "   " . ($index + 1) . ". " . $room['name'] . 
                     " (ID: " . $room['id'] . 
                     ", Capacity: " . $room['capacity'] . ")" . PHP_EOL;
            }
        } else {
            echo "⚠️  Invalid response format" . PHP_EOL;
        }
    } else {
        echo "⚠️  API returned HTTP " . $httpCode . PHP_EOL;
        echo "Response: " . substr($response, 0, 200) . PHP_EOL;
    }
}

echo PHP_EOL . "=== TEST COMPLETE ===" . PHP_EOL;
