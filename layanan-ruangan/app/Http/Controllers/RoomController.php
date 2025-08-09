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
     * 
     * @OA\Get(
     *     path="/api/rooms",
     *     summary="Get all rooms",
     *     description="Retrieve a list of all rooms with their facilities",
     *     operationId="getRooms",
     *     tags={"Rooms"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Rooms retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Meeting Room A"),
     *                     @OA\Property(property="capacity", type="integer", example=10),
     *                     @OA\Property(property="status", type="string", example="available"),
     *                     @OA\Property(property="facilities_text", type="string", example="Proyektor, AC"),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 )
     *             )
     *         )
     *     )
     * )
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
     * 
     * @OA\Post(
     *     path="/api/rooms",
     *     summary="Create a new room",
     *     description="Create a new room in the system",
     *     operationId="createRoom",
     *     tags={"Rooms"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "capacity"},
     *             @OA\Property(property="name", type="string", example="Meeting Room B"),
     *             @OA\Property(property="capacity", type="integer", example=15),
     *             @OA\Property(property="description", type="string", example="Large meeting room with projector")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Room created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Room created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Meeting Room B"),
     *                 @OA\Property(property="capacity", type="integer", example=15),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        // Temporary validation for debugging
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|string|in:available,unavailable'
        ]);
        
        $room = Room::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Room created successfully',
            'data' => $room
        ], 201);
    }

    public function testStore(Request $request): JsonResponse 
    {
        return response()->json([
            'success' => true,
            'message' => 'Test store method works!',
            'data' => $request->all()
        ], 200);
    }

    /**
     * Display the specified resource.
     * 
     * @OA\Get(
     *     path="/api/rooms/{id}",
     *     summary="Get a specific room",
     *     description="Retrieve details of a specific room by ID",
     *     operationId="getRoom",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Room ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Room retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Meeting Room A"),
     *                 @OA\Property(property="capacity", type="integer", example=10),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Room]")
     *         )
     *     )
     * )
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
     * 
     * @OA\Put(
     *     path="/api/rooms/{id}",
     *     summary="Update a room",
     *     description="Update an existing room by ID",
     *     operationId="updateRoom",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Room ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Meeting Room"),
     *             @OA\Property(property="capacity", type="integer", example=20),
     *             @OA\Property(property="description", type="string", example="Updated room description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Room updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Updated Meeting Room"),
     *                 @OA\Property(property="capacity", type="integer", example=20),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
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
     * 
     * @OA\Delete(
     *     path="/api/rooms/{id}",
     *     summary="Delete a room",
     *     description="Delete an existing room by ID",
     *     operationId="deleteRoom",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Room ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Room deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Room]")
     *         )
     *     )
     * )
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
