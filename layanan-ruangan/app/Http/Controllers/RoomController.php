<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $rooms = Room::with('facilities')->get();
        
        // Transform the data to include facilities information
        $transformedRooms = $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'capacity' => $room->capacity,
                'status' => 'available', // You can implement status logic
                'facilities' => $room->facilities->map(function ($facility) {
                    return [
                        'id' => $facility->id,
                        'name' => $facility->name,
                        'icon' => $facility->icon,
                        'color' => $facility->color,
                        'quantity' => $facility->pivot->quantity,
                        'notes' => $facility->pivot->notes,
                    ];
                }),
                'facilities_text' => $room->facilities->pluck('name')->join(', '), // For backward compatibility
                'created_at' => $room->created_at,
                'updated_at' => $room->updated_at,
            ];
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Rooms retrieved successfully',
            'data' => $transformedRooms
        ]);
    }

    /**
     * Display the web interface
     */
    public function webIndex()
    {
        $rooms = Room::with('facilities')->get();
        return view('welcome', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request): JsonResponse
    {
        $room = Room::create($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Room created successfully',
            'data' => $room
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Room retrieved successfully',
            'data' => $room
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room): JsonResponse
    {
        $room->update($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully',
            'data' => $room->refresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room): JsonResponse
    {
        $room->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Room deleted successfully'
        ]);
    }

    /**
     * Get statistics for dashboard
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total' => Room::count(),
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Search rooms
     */
    public function search(Request $request): JsonResponse
    {
        $query = Room::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $rooms = $query->get();

        return response()->json([
            'success' => true,
            'rooms' => $rooms
        ]);
    }
}
