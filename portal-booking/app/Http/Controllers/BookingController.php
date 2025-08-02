<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Services\RoomService;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        
        // Calculate stats efficiently
        $totalBookings = $bookings->count();
        $upcomingBookings = Booking::where('start_time', '>', now())->count();
        $todayBookings = Booking::whereDate('created_at', today())->count();
        
        // Get rooms for dropdown
        $rooms = $this->roomService->getAllRooms();
        
        return view('bookings.index', compact('bookings', 'totalBookings', 'upcomingBookings', 'todayBookings', 'rooms'));
    }

    public function create()
    {
        $rooms = $this->roomService->getAllRooms();
        return view('bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'room_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Validate room exists in API
        if (!$this->roomService->isRoomValid($request->room_id)) {
            return back()->withErrors(['room_id' => 'Ruangan yang dipilih tidak tersedia.'])->withInput();
        }

        Booking::create([
            'user_id' => Auth::id() ?? 1, // Use authenticated user ID or default to 1
            'user_name' => $request->user_name,
            'room_id' => $request->room_id,
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil ditambahkan!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dihapus!');
    }
}