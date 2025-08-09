<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Booking Ruang Rapat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="user_name" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                            <input type="text" id="user_name" name="user_name" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('user_name', $booking->user_name) }}">
                            @error('user_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="room_id" class="block text-sm font-medium text-gray-700">Pilih Ruangan</label>
                            <select id="room_id" name="room_id" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Pilih Ruangan --</option>
                                @forelse($rooms as $room)
                                    <option value="{{ $room['id'] }}" {{ old('room_id', $booking->room_id) == $room['id'] ? 'selected' : '' }}>
                                        {{ $room['name'] }}
                                    </option>
                                @empty
                                    <option value="" disabled>Tidak ada ruangan tersedia</option>
                                @endforelse
                            </select>
                            @error('room_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Room Details - Initially Hidden -->
                        <div id="room-details" class="mb-4 hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-blue-800 mb-3">Detail Ruangan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Room Capacity -->
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700">Kapasitas</h4>
                                    <p id="room-capacity" class="text-lg text-blue-600 font-bold">-</p>
                                </div>

                                <!-- Room Facilities -->
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700">Fasilitas</h4>
                                    <div id="room-facilities" class="text-sm text-gray-600">
                                        <p class="text-gray-400 italic">Pilih ruangan untuk melihat fasilitas</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Booking</label>
                            <input type="text" id="title" name="title" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('title', $booking->title) }}">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                                <input type="datetime-local" id="start_time" name="start_time" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                       value="{{ old('start_time', $booking->start_time ? \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d\TH:i') : '') }}">
                                @error('start_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                                <input type="datetime-local" id="end_time" name="end_time" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                       value="{{ old('end_time', $booking->end_time ? \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d\TH:i') : '') }}">
                                @error('end_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('bookings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Room data from server
        const roomsData = @json($rooms ?? []);
        
        // Create a lookup object for quick access
        const roomsLookup = {};
        roomsData.forEach(room => {
            roomsLookup[room.id] = room;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const roomSelect = document.getElementById('room_id');
            const roomDetailsDiv = document.getElementById('room-details');
            const roomCapacityEl = document.getElementById('room-capacity');
            const roomFacilitiesEl = document.getElementById('room-facilities');
            
            // Handle room selection change
            roomSelect.addEventListener('change', function() {
                const selectedRoomId = this.value;
                
                if (selectedRoomId && roomsLookup[selectedRoomId]) {
                    const room = roomsLookup[selectedRoomId];
                    
                    // Show room details
                    roomDetailsDiv.classList.remove('hidden');
                    
                    // Update capacity
                    roomCapacityEl.textContent = room.capacity ? `${room.capacity} orang` : 'Tidak tersedia';
                    
                    // Update facilities
                    if (room.facilities && room.facilities.length > 0) {
                        let facilitiesHtml = '<div class="flex flex-wrap gap-2">';
                        room.facilities.forEach(facility => {
                            facilitiesHtml += `
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    ${facility.name}${facility.quantity ? ` (${facility.quantity})` : ''}
                                </span>
                            `;
                        });
                        facilitiesHtml += '</div>';
                        roomFacilitiesEl.innerHTML = facilitiesHtml;
                    } else if (room.facilities_text) {
                        // Fallback to facilities_text if facilities array is not available
                        roomFacilitiesEl.innerHTML = `<p class="text-sm text-gray-600">${room.facilities_text}</p>`;
                    } else {
                        roomFacilitiesEl.innerHTML = '<p class="text-gray-400 italic">Tidak ada fasilitas tersedia</p>';
                    }
                } else {
                    // Hide room details if no room selected
                    roomDetailsDiv.classList.add('hidden');
                    roomCapacityEl.textContent = '-';
                    roomFacilitiesEl.innerHTML = '<p class="text-gray-400 italic">Pilih ruangan untuk melihat fasilitas</p>';
                }
            });

            // Trigger room details display for pre-selected room
            if (roomSelect.value) {
                roomSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
    @endpush
</x-app-layout>
