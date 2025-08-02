<?php

namespace App\Http\Controllers;

use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoomManagementController extends Controller
{
    private RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * Display all rooms
     */
    public function index()
    {
        $rooms = $this->roomService->getAllRooms();
        
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a new room via API
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'facilities' => 'nullable|array'
        ]);

        $result = $this->roomService->createRoom($request->all());

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Room created successfully',
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'errors' => $result['errors'] ?? null
        ], $result['status'] ?? 500);
    }

    /**
     * Show a specific room
     */
    public function show($id)
    {
        $room = $this->roomService->getRoomById($id);
        
        if (!$room) {
            abort(404, 'Room not found');
        }

        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing a room
     */
    public function edit($id)
    {
        $room = $this->roomService->getRoomById($id);
        
        if (!$room) {
            abort(404, 'Room not found');
        }

        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update a room via API
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'facilities' => 'nullable|array'
        ]);

        $result = $this->roomService->updateRoom($id, $request->all());

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Room updated successfully',
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'errors' => $result['errors'] ?? null
        ], $result['status'] ?? 500);
    }

    /**
     * Delete a room via API
     */
    public function destroy($id): JsonResponse
    {
        $result = $this->roomService->deleteRoom($id);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], $result['status'] ?? 500);
    }

    /**
     * API endpoint to get all rooms (for frontend)
     */
    public function apiIndex(): JsonResponse
    {
        $rooms = $this->roomService->getAllRooms();
        
        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    /**
     * API endpoint to get a specific room
     */
    public function apiShow($id): JsonResponse
    {
        $room = $this->roomService->getRoomById($id);
        
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $room
        ]);
    }
}
