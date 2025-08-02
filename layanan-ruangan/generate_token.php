<?php

// Script untuk generate API token
require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Cari atau buat user
    $user = User::firstOrCreate(
        ['email' => 'admin@room-service.com'],
        [
            'name' => 'Room Service Admin',
            'email' => 'admin@room-service.com',
            'password' => Hash::make('password123')
        ]
    );

    // Hapus token lama jika ada
    $user->tokens()->delete();

    // Buat token baru dengan ability untuk room management
    $token = $user->createToken('room-api-token', ['room:read', 'room:write', 'room:delete'])->plainTextToken;

    echo "=== API TOKEN GENERATED ===\n";
    echo "User: {$user->name} ({$user->email})\n";
    echo "Token: {$token}\n";
    echo "Abilities: room:read, room:write, room:delete\n";
    echo "===========================\n\n";

    echo "Usage Example:\n";
    echo "curl -X GET http://localhost:8081/api/rooms \\\n";
    echo "  -H \"Authorization: Bearer {$token}\" \\\n";
    echo "  -H \"Content-Type: application/json\"\n\n";

    // Test token dengan membuat request internal
    echo "Testing token...\n";
    $tokenModel = $user->tokens()->first();
    if ($tokenModel) {
        echo "✅ Token created successfully!\n";
        echo "Token ID: {$tokenModel->id}\n";
        echo "Token Name: {$tokenModel->name}\n";
        echo "Abilities: " . implode(', ', $tokenModel->abilities) . "\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
