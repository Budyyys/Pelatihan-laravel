<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\RoomService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index()
    {
        // Calculate stats
        $totalBookings = Booking::count();
        $upcomingBookings = Booking::where('start_time', '>', now())->count();
        $todayBookings = Booking::whereDate('created_at', today())->count();
        
        // Get recent bookings (last 6)
        $recentBookings = Booking::orderBy('created_at', 'desc')
                                ->limit(6)
                                ->get();
        
        // Get rooms for dropdown
        $rooms = $this->roomService->getAllRooms();
        
        return view('dashboard', compact(
            'totalBookings', 
            'upcomingBookings', 
            'todayBookings', 
            'recentBookings',
            'rooms'
        ));
    }
}
