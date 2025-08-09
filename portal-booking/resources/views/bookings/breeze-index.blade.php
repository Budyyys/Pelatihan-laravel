<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Booking Ruang Rapat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Alert -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-blue-100 text-sm font-medium">Total Booking</p>
                                <p class="text-3xl font-bold">{{ $totalBookings }}</p>
                            </div>
                            <div class="text-blue-200">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-green-500 to-green-600 text-white">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-green-100 text-sm font-medium">Booking Mendatang</p>
                                <p class="text-3xl font-bold">{{ $upcomingBookings }}</p>
                            </div>
                            <div class="text-green-200">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-purple-100 text-sm font-medium">Booking Hari Ini</p>
                                <p class="text-3xl font-bold">{{ $todayBookings }}</p>
                            </div>
                            <div class="text-purple-200">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Booking</h3>
                            <p class="text-gray-600">Kelola semua booking ruang rapat</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Cari booking..." 
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <button onclick="openCreateForm()" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Booking
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings Table/Cards -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($bookings->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruangan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="bookingTableBody">
                                    @foreach($bookings as $booking)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-medium text-blue-600">#{{ $booking->id }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $booking->user_name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 room-badge" data-room-id="{{ $booking->room_id }}">
                                                    Loading...
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $booking->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    s/d {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $booking->created_at->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex gap-2">
                                                    <button onclick="openEditForm({{ $booking->id }})" 
                                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition-colors">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit
                                                    </button>
                                                    <form action="/bookings/{{ $booking->id }}" method="POST" class="inline" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden" id="bookingCardsContainer">
                        @foreach($bookings as $booking)
                            <div class="border-b border-gray-200 p-4 booking-card-mobile">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $booking->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $booking->user_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs font-medium text-blue-600">#{{ $booking->id }}</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 room-badge" data-room-id="{{ $booking->room_id }}">
                                            Loading...
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }} - 
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Dibuat {{ $booking->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex justify-end gap-2">
                                    <button onclick="openEditForm({{ $booking->id }})" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition-colors">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <form action="/bookings/{{ $booking->id }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Booking</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat booking ruang rapat pertama Anda</p>
                        <div class="mt-6">
                            <button onclick="openCreateForm()" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Booking Pertama
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Booking Modal -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50" id="createBookingModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 rounded-t-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Booking Baru
                        </h3>
                        <button onclick="closeCreateForm()" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    
                    <div>
                        <label for="user_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                        <input type="text" id="user_name" name="user_name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama lengkap" value="{{ old('user_name', Auth::user()->name) }}">
                        @error('user_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Ruangan</label>
                        <select id="room_id" name="room_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Ruangan --</option>
                            @if(isset($rooms) && count($rooms) > 0)
                                @foreach($rooms as $room)
                                    <option value="{{ $room['id'] }}" {{ old('room_id') == $room['id'] ? 'selected' : '' }}>
                                        {{ $room['name'] }} (Kapasitas: {{ $room['capacity'] }} orang)
                                    </option>
                                @endforeach
                            @else
                                <option value="1" {{ old('room_id') == '1' ? 'selected' : '' }}>Ruang Meeting A</option>
                                <option value="2" {{ old('room_id') == '2' ? 'selected' : '' }}>Ruang Meeting B</option>
                                <option value="3" {{ old('room_id') == '3' ? 'selected' : '' }}>Ruang Seminar</option>
                            @endif
                        </select>
                        @error('room_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Booking</label>
                        <input type="text" id="title" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Meeting Tim Development" value="{{ old('title') }}">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                            <input type="datetime-local" id="start_time" name="start_time" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('start_time') }}">
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                            <input type="datetime-local" id="end_time" name="end_time" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('end_time') }}">
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition-colors">
                            Simpan Booking
                        </button>
                        <button type="button" onclick="closeCreateForm()" 
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded-lg font-medium transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Booking Modal -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50" id="editBookingModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4 rounded-t-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Booking
                        </h3>
                        <button onclick="closeEditForm()" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form id="editBookingForm" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="edit_user_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                        <input type="text" id="edit_user_name" name="user_name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <div>
                        <label for="edit_room_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Ruangan</label>
                        <select id="edit_room_id" name="room_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">-- Pilih Ruangan --</option>
                            @if(isset($rooms) && count($rooms) > 0)
                                @foreach($rooms as $room)
                                    <option value="{{ $room['id'] }}">
                                        {{ $room['name'] }} (Kapasitas: {{ $room['capacity'] }} orang)
                                    </option>
                                @endforeach
                            @else
                                <option value="1">Ruang Meeting A</option>
                                <option value="2">Ruang Meeting B</option>
                                <option value="3">Ruang Seminar</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-1">Judul Booking</label>
                        <input type="text" id="edit_title" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                               placeholder="Meeting Tim Development">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_start_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                            <input type="datetime-local" id="edit_start_time" name="start_time" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        
                        <div>
                            <label for="edit_end_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                            <input type="datetime-local" id="edit_end_time" name="end_time" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-medium transition-colors">
                            Update Booking
                        </button>
                        <button type="button" onclick="closeEditForm()" 
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded-lg font-medium transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Room data from API (passed from PHP)
        const roomsData = @json($rooms ?? []);
        
        // Bookings data for editing
        const bookingsData = @json($bookings->toArray());
        
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
            const booking = bookingsData.find(b => b.id === bookingId);
            if (!booking) {
                alert('Booking tidak ditemukan!');
                return;
            }
            
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
        
        // Enhanced search functionality for both desktop and mobile
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            // Search in desktop table
            const tableRows = document.querySelectorAll('#bookingTableBody tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
            
            // Search in mobile cards
            const mobileCards = document.querySelectorAll('.booking-card-mobile');
            mobileCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
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
        });

        // Show modal if there are validation errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openCreateForm();
            });
        @endif
    </script>
</x-app-layout>
