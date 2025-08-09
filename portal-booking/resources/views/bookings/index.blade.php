<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    📅 Booking Management
                </h2>
                <p class="text-sm text-gray-500 mt-1">Manage your meeting room reservations</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="openCreateForm()" 
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>New Booking</span>
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Modern Styling -->
    <style>
        /* Minimal, modern additions. Keep it lightweight; most styles via Tailwind */
        .tooltip { position: relative; }
        .tooltip:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(17, 24, 39, 0.95);
            color: #fff;
            padding: 8px 12px;
            border-radius: 12px;
            font-size: 12px;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
            z-index: 50;
            animation: tooltipFadeIn 0.2s ease-out;
        }
        .tooltip:hover::before {
            content: '';
            position: absolute;
            bottom: calc(100% - 4px);
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-top-color: rgba(17, 24, 39, 0.95);
            z-index: 50;
            animation: tooltipFadeIn 0.2s ease-out;
        }
        @keyframes tooltipFadeIn {
            from { opacity: 0; transform: translateX(-50%) translateY(4px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }
        .modal-enter { opacity: 0; transform: scale(.98); }
        .modal-enter-active { opacity: 1; transform: scale(1); transition: opacity .2s ease, transform .2s ease; }
        .sticky-header thead th { position: sticky; top: 0; background: #fff; z-index: 10; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .booking-card-mobile:hover { transform: translateY(-1px); }
        /* Smooth focus states */
        input:focus, select:focus, button:focus { outline: none; }
        /* Custom scrollbar for webkit browsers */
        .overflow-x-auto::-webkit-scrollbar { height: 6px; }
        .overflow-x-auto::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
        .overflow-x-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Alert -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-blue-50">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalBookings }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-emerald-50">
                            <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Upcoming</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $upcomingBookings }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-purple-50">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Today</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $todayBookings }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Component Section -->
            <div class="mb-20">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100 shadow-sm">
                    <div class="relative w-full max-w-md mx-auto">
                        <span class="sr-only">Search bookings</span>
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input id="searchInput" type="text" placeholder="Search bookings..." class="w-full pl-10 pr-4 py-3 bg-white border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-200 shadow-sm" />
                    </div>
                </div>
            </div>

            <!-- Visual Separator -->
            <div class="flex items-center justify-center mb-12">
                <div class="flex-grow h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                <div class="px-4">
                    <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                </div>
                <div class="flex-grow h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
            </div>

            <!-- Booking Cards Section -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @if($bookings->count() > 0)
                    <!-- Card View for All Devices -->
                    <div class="space-y-4 p-4" id="bookingCardsContainer">
                        @foreach($bookings as $booking)
                            <div class="bg-white rounded-xl p-4 booking-card-mobile border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200"
                                 data-created="{{ $booking->created_at->toISOString() }}" 
                                 data-start-time="{{ $booking->start_time }}">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-semibold text-sm">
                                            #{{ $booking->id }}
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="font-semibold text-gray-900 text-sm">{{ $booking->title }}</h4>
                                            <p class="text-xs text-gray-500">{{ $booking->user_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    @php
                                        $now = now();
                                        $startTime = \Carbon\Carbon::parse($booking->start_time);
                                        $endTime = \Carbon\Carbon::parse($booking->end_time);
                                    @endphp
                                    @if($now->lt($startTime))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                            <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5"></div>
                                            Upcoming
                                        </span>
                                    @elseif($now->between($startTime, $endTime))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-blue-200">
                                            <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1.5"></div>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-700 ring-1 ring-gray-200">
                                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></div>
                                            Completed
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="room-badge" data-room-id="{{ $booking->room_id }}">Loading...</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($booking->start_time)->format('M d, Y') }}</span>
                                        <span class="mx-1 text-gray-400">•</span>
                                        <span>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100">
                                    <button onclick="openEditForm({{ $booking->id }})" 
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors duration-150 ring-1 ring-amber-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <form action="/bookings/{{ $booking->id }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-150 ring-1 ring-red-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 ring-1 ring-inset ring-gray-100">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No bookings yet</h3>
                            <p class="text-gray-500 mb-6">Create your first reservation in seconds</p>
                            <button onclick="openCreateForm()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/></svg>
                                Create Booking
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create Booking Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4" id="createBookingModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        Create New Booking
                    </h3>
                    <button onclick="closeCreateForm()" 
                            class="p-2 hover:bg-gray-100 rounded-xl transition-colors duration-150">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('bookings.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                
                <div>
                    <label for="user_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Organizer Name
                    </label>
                    <input type="text" id="user_name" name="user_name" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150"
                           placeholder="Enter organizer name" value="{{ old('user_name', Auth::user()?->name ?? '') }}">
                    @error('user_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="room_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Room
                    </label>
                    <select id="room_id" name="room_id" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150">
                        <option value="">Choose a room...</option>
                        @if(isset($rooms) && count($rooms) > 0)
                            @foreach($rooms as $room)
                                <option value="{{ $room['id'] }}" {{ old('room_id') == $room['id'] ? 'selected' : '' }}>
                                    {{ $room['name'] }} (Capacity: {{ $room['capacity'] }} people)
                                </option>
                            @endforeach
                        @else
                            <option value="1" {{ old('room_id') == '1' ? 'selected' : '' }}>Meeting Room A</option>
                            <option value="2" {{ old('room_id') == '2' ? 'selected' : '' }}>Meeting Room B</option>
                            <option value="3" {{ old('room_id') == '3' ? 'selected' : '' }}>Seminar Room</option>
                        @endif
                    </select>
                    @error('room_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Meeting Title
                    </label>
                    <input type="text" id="title" name="title" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150"
                           placeholder="Enter meeting title" value="{{ old('title') }}">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Time
                        </label>
                        <input type="datetime-local" id="start_time" name="start_time" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150"
                               value="{{ old('start_time') }}">
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                            End Time
                        </label>
                        <input type="datetime-local" id="end_time" name="end_time" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150"
                               value="{{ old('end_time') }}">
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeCreateForm()" 
                            class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors duration-150">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        Create Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Booking Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4" id="editBookingModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        Edit Booking
                    </h3>
                    <button onclick="closeEditForm()" 
                            class="p-2 hover:bg-gray-100 rounded-xl transition-colors duration-150">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="editBookingForm" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="edit_user_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Organizer Name
                    </label>
                    <input type="text" id="edit_user_name" name="user_name" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-150"
                           placeholder="Enter organizer name">
                </div>

                <div>
                    <label for="edit_room_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Room
                    </label>
                    <select id="edit_room_id" name="room_id" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-150">
                        <option value="">Choose a room...</option>
                        @if(isset($rooms) && count($rooms) > 0)
                            @foreach($rooms as $room)
                                <option value="{{ $room['id'] }}">
                                    {{ $room['name'] }} (Capacity: {{ $room['capacity'] }} people)
                                </option>
                            @endforeach
                        @else
                            <option value="1">Meeting Room A</option>
                            <option value="2">Meeting Room B</option>
                            <option value="3">Seminar Room</option>
                        @endif
                    </select>
                </div>

                <div>
                    <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Meeting Title
                    </label>
                    <input type="text" id="edit_title" name="title" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-150"
                           placeholder="Enter meeting title">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Time
                        </label>
                        <input type="datetime-local" id="edit_start_time" name="start_time" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-150">
                    </div>
                    
                    <div>
                        <label for="edit_end_time" class="block text-sm font-medium text-gray-700 mb-2">
                            End Time
                        </label>
                        <input type="datetime-local" id="edit_end_time" name="end_time" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-150">
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditForm()" 
                            class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors duration-150">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Room data from API (passed from PHP)
        const roomsData = @json($rooms ?? []);
        
        // Bookings data for editing
        const bookingsData = @json($bookings);
        
        function openCreateForm() {
            const modal = document.getElementById('createBookingModal');
            modal.classList.remove('hidden');
            
            // Set minimum date to today
            const today = new Date();
            const todayString = today.toISOString().slice(0, 16);
            document.getElementById('start_time').min = todayString;
            document.getElementById('end_time').min = todayString;
        }
        
        function closeCreateForm() {
            const modal = document.getElementById('createBookingModal');
            modal.classList.add('hidden');
        }

        function openEditForm(bookingId) {
            console.log('Opening edit form for booking ID:', bookingId);
            console.log('Available bookings data:', bookingsData);
            
            const booking = bookingsData.find(b => b.id === bookingId);
            if (!booking) {
                alert('Booking tidak ditemukan!');
                console.error('Booking not found for ID:', bookingId);
                return;
            }
            
            console.log('Found booking:', booking);
            
            // Fill the edit form with booking data
            document.getElementById('edit_user_name').value = booking.user_name || '';
            document.getElementById('edit_room_id').value = booking.room_id || '';
            document.getElementById('edit_title').value = booking.title || '';
            
            // Format datetime for input fields
            if (booking.start_time) {
                const startDate = new Date(booking.start_time);
                document.getElementById('edit_start_time').value = startDate.toISOString().slice(0, 16);
            }
            
            if (booking.end_time) {
                const endDate = new Date(booking.end_time);
                document.getElementById('edit_end_time').value = endDate.toISOString().slice(0, 16);
            }
            
            // Set form action
            const form = document.getElementById('editBookingForm');
            form.action = `/bookings/${bookingId}`;
            
            // Set minimum date to today
            const today = new Date();
            const todayString = today.toISOString().slice(0, 16);
            document.getElementById('edit_start_time').min = todayString;
            document.getElementById('edit_end_time').min = todayString;
            
            // Show modal
            const modal = document.getElementById('editBookingModal');
            modal.classList.remove('hidden');
        }
        
        function closeEditForm() {
            const modal = document.getElementById('editBookingModal');
            modal.classList.add('hidden');
        }
        
        // Load room names for existing bookings
        function loadRoomNames() {
            if (roomsData.length === 0) {
                document.querySelectorAll('.room-badge[data-room-id]').forEach(badge => {
                    const roomId = badge.dataset.roomId;
                    badge.textContent = `Room ${roomId}`;
                });
                return;
            }
            
            document.querySelectorAll('.room-badge[data-room-id]').forEach(badge => {
                const roomId = parseInt(badge.dataset.roomId);
                const room = roomsData.find(r => r.id === roomId);
                
                if (room) {
                    badge.textContent = room.name;
                } else {
                    badge.textContent = `Room ${roomId}`;
                    badge.classList.add('opacity-60');
                }
            });
        }
        
        // Enhanced search functionality
        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            // Search in mobile cards
            const mobileCards = document.querySelectorAll('.booking-card-mobile');
            mobileCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const matchesSearch = searchTerm === '' || text.includes(searchTerm);
                card.style.display = matchesSearch ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('input', performSearch);
        
        // Auto-adjust end time when start time changes
        document.getElementById('start_time').addEventListener('change', function() {
            const startTime = new Date(this.value);
            const endTime = new Date(startTime.getTime() + (60 * 60 * 1000)); // Add 1 hour
            document.getElementById('end_time').min = this.value;
            
            if (!document.getElementById('end_time').value) {
                document.getElementById('end_time').value = endTime.toISOString().slice(0, 16);
            }
        });

        // Auto-adjust end time when start time changes in edit form
        document.getElementById('edit_start_time').addEventListener('change', function() {
            const startTime = new Date(this.value);
            const endTime = new Date(startTime.getTime() + (60 * 60 * 1000)); // Add 1 hour
            document.getElementById('edit_end_time').min = this.value;
            
            // Update end time if it's earlier than start time
            const currentEndTime = new Date(document.getElementById('edit_end_time').value);
            if (currentEndTime <= startTime) {
                document.getElementById('edit_end_time').value = endTime.toISOString().slice(0, 16);
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('createBookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateForm();
            }
        });

        // Close edit modal when clicking outside
        document.getElementById('editBookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditForm();
            }
        });
        
        // Load room names when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadRoomNames();
            
            // Debug: Check if data is loaded correctly
            console.log('Rooms data:', roomsData);
            console.log('Bookings data:', bookingsData);
        });

        // Show modal if there are validation errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openCreateForm();
            });
        @endif
    </script>
</x-app-layout>
