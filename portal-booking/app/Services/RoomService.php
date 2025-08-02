<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RoomService
{
    private string $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = 'http://room-service-nginx/api';
    }

    /**
     * Get all rooms from external API
     */
    public function getAllRooms(): array
    {
        try {
            $response = Http::timeout(10)->get($this->apiBaseUrl . '/rooms');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success'] && isset($data['data'])) {
                    return $data['data'];
                }
            }
            
            Log::warning('Failed to fetch rooms from API', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            
            return [];
            
        } catch (\Exception $e) {
            Log::error('Error fetching rooms from API: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a specific room by ID
     */
    public function getRoomById(int $roomId): ?array
    {
        try {
            $response = Http::timeout(10)->get($this->apiBaseUrl . "/rooms/{$roomId}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success'] && isset($data['data'])) {
                    return $data['data'];
                }
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Error fetching room by ID from API: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Check if room exists and is available
     */
    public function isRoomValid(int $roomId): bool
    {
        $room = $this->getRoomById($roomId);
        return $room !== null;
    }
}
