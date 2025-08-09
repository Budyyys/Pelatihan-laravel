<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Services\RoomService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        
        // Convert rooms data to JSON for JavaScript usage
        $roomsJson = json_encode($rooms);
        
        return view('bookings.create', compact('rooms', 'roomsJson'));
    }

    public function store(Request $request)
    {
        Log::info('Booking store method called', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'user_name' => 'required|string|max:255',
            'room_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        Log::info('Validation passed, checking room validity', ['room_id' => $request->room_id]);

        // Validate room exists in API
        if (!$this->roomService->isRoomValid($request->room_id)) {
            Log::warning('Room validation failed', ['room_id' => $request->room_id]);
            return redirect()->route('dashboard')->withErrors(['room_id' => 'Ruangan yang dipilih tidak tersedia.'])->withInput();
        }

        Log::info('Room validation passed, checking for conflicts');

        // Check for conflicting bookings
        $conflictingBooking = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    // New start time is between existing booking times
                    $q->where('start_time', '<=', $request->start_time)
                      ->where('end_time', '>', $request->start_time);
                })->orWhere(function ($q) use ($request) {
                    // New end time is between existing booking times
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>=', $request->end_time);
                })->orWhere(function ($q) use ($request) {
                    // New booking encompasses existing booking
                    $q->where('start_time', '>=', $request->start_time)
                      ->where('end_time', '<=', $request->end_time);
                });
            })
            ->first();

        if ($conflictingBooking) {
            $conflictMessage = sprintf(
                'Ruangan tidak tersedia pada jadwal yang dipilih. Bentrok dengan booking "%s" dari %s sampai %s.',
                $conflictingBooking->title,
                \Carbon\Carbon::parse($conflictingBooking->start_time)->format('d/m/Y H:i'),
                \Carbon\Carbon::parse($conflictingBooking->end_time)->format('d/m/Y H:i')
            );
            
            return redirect()->route('dashboard')->withErrors([
                'schedule' => $conflictMessage
            ])->withInput()->with('alert_type', 'conflict');
        }

        Booking::create([
            'user_id' => Auth::id() ?? 1, // Use authenticated user ID or default to 1
            'user_name' => $request->user_name,
            'room_id' => $request->room_id,
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $successMessage = sprintf(
            'Booking berhasil ditambahkan! "%s" dijadwalkan untuk ruangan %s pada %s sampai %s.',
            $request->title,
            $request->room_id,
            \Carbon\Carbon::parse($request->start_time)->format('d/m/Y H:i'),
            \Carbon\Carbon::parse($request->end_time)->format('d/m/Y H:i')
        );

        return redirect()->route('dashboard')->with([
            'success' => $successMessage,
            'alert_type' => 'success'
        ]);
    }

    public function edit(Booking $booking)
    {
        $rooms = $this->roomService->getAllRooms();
        
        // Convert rooms data to JSON for JavaScript usage
        $roomsJson = json_encode($rooms);
        
        return view('bookings.edit', compact('booking', 'rooms', 'roomsJson'));
    }

    public function update(Request $request, Booking $booking)
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
            return redirect()->route('dashboard')->withErrors(['room_id' => 'Ruangan yang dipilih tidak tersedia.'])->withInput();
        }

        // Check for conflicting bookings (exclude current booking)
        $conflictingBooking = Booking::where('room_id', $request->room_id)
            ->where('id', '!=', $booking->id) // Exclude current booking
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    // New start time is between existing booking times
                    $q->where('start_time', '<=', $request->start_time)
                      ->where('end_time', '>', $request->start_time);
                })->orWhere(function ($q) use ($request) {
                    // New end time is between existing booking times
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>=', $request->end_time);
                })->orWhere(function ($q) use ($request) {
                    // New booking encompasses existing booking
                    $q->where('start_time', '>=', $request->start_time)
                      ->where('end_time', '<=', $request->end_time);
                });
            })
            ->first();

        if ($conflictingBooking) {
            $conflictMessage = sprintf(
                'Ruangan tidak tersedia pada jadwal yang dipilih. Bentrok dengan booking "%s" dari %s sampai %s.',
                $conflictingBooking->title,
                \Carbon\Carbon::parse($conflictingBooking->start_time)->format('d/m/Y H:i'),
                \Carbon\Carbon::parse($conflictingBooking->end_time)->format('d/m/Y H:i')
            );
            
            return redirect()->route('dashboard')->withErrors([
                'schedule' => $conflictMessage
            ])->withInput()->with('alert_type', 'conflict');
        }

        $booking->update([
            'user_name' => $request->user_name,
            'room_id' => $request->room_id,
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $successMessage = sprintf(
            'Booking berhasil diperbarui! "%s" dijadwalkan untuk ruangan %s pada %s sampai %s.',
            $request->title,
            $request->room_id,
            \Carbon\Carbon::parse($request->start_time)->format('d/m/Y H:i'),
            \Carbon\Carbon::parse($request->end_time)->format('d/m/Y H:i')
        );

        return redirect()->route('dashboard')->with([
            'success' => $successMessage,
            'alert_type' => 'success'
        ]);
    }

    public function destroy(Booking $booking)
    {
        $bookingTitle = $booking->title;
        $booking->delete();
        
        return redirect()->route('dashboard')->with([
            'success' => "Booking \"$bookingTitle\" berhasil dihapus!",
            'alert_type' => 'success'
        ]);
    }
}