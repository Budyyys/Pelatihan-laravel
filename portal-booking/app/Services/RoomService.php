<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RoomService
{
    private string $apiBaseUrl;
    private string $token;

    public function __construct()
    {
        $this->apiBaseUrl = env('ROOM_SERVICE_API_URL', 'http://room-service-nginx/api');
        $this->token = env('ROOM_SERVICE_TOKEN');
    }

    /**
     * Get authorization headers
     */
    private function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Get all rooms from external API
     */
    public function getAllRooms(): array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->get($this->apiBaseUrl . '/rooms');
            
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
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->get($this->apiBaseUrl . "/rooms/{$roomId}");
            
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
     * Create a new room
     */
    public function createRoom(array $data): array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->post($this->apiBaseUrl . '/rooms', $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create room',
                'errors' => $response->json(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Room Service API Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Connection error to room service'
            ];
        }
    }

    /**
     * Update an existing room
     */
    public function updateRoom(int $roomId, array $data): array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->put($this->apiBaseUrl . "/rooms/{$roomId}", $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to update room',
                'errors' => $response->json(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Room Service API Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Connection error to room service'
            ];
        }
    }

    /**
     * Delete a room
     */
    public function deleteRoom(int $roomId): array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->delete($this->apiBaseUrl . "/rooms/{$roomId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Room deleted successfully'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to delete room',
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Room Service API Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Connection error to room service'
            ];
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
