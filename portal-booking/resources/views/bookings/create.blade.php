<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Booking Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
                        @csrf

                        <!-- User Name -->
                        <div>
                            <label for="user_name" class="block text-sm font-medium text-gray-700">
                                Nama Pengguna
                            </label>
                            <input 
                                type="text" 
                                id="user_name" 
                                name="user_name" 
                                value="{{ old('user_name') }}"
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- Room Selection -->
                        <div>
                            <label for="room_id" class="block text-sm font-medium text-gray-700">
                                Pilih Ruangan
                            </label>
                            
                            <select 
                                id="room_id" 
                                name="room_id" 
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">-- Pilih Ruangan --</option>
                                @forelse($rooms as $room)
                                    <option value="{{ $room['id'] }}" {{ old('room_id') == $room['id'] ? 'selected' : '' }}>
                                        {{ $room['name'] }}
                                    </option>
                                @empty
                                    <option value="" disabled>Tidak ada ruangan tersedia</option>
                                @endforelse
                            </select>
                            @if(empty($rooms))
                                <p class="mt-1 text-sm text-red-600">
                                    Tidak dapat memuat daftar ruangan. Pastikan layanan ruangan berjalan dengan baik.
                                </p>
                            @endif
                        </div>

                        <!-- Room Details - Initially Hidden -->
                        <div id="room-details" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
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

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Judul Booking
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                required 
                                placeholder="Contoh: Rapat Tim Marketing"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">
                                Waktu Mulai
                            </label>
                            <input 
                                type="datetime-local" 
                                id="start_time" 
                                name="start_time" 
                                value="{{ old('start_time') }}"
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700">
                                Waktu Selesai
                            </label>
                            <input 
                                type="datetime-local" 
                                id="end_time" 
                                name="end_time" 
                                value="{{ old('end_time') }}"
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <a 
                                href="{{ route('bookings.index') }}" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150"
                            >
                                Batal
                            </a>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150"
                            >
                                Simpan Booking
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

            // Set minimum datetime to current time
            const now = new Date();
            const formattedDateTime = now.toISOString().slice(0, 16);
            
            document.getElementById('start_time').min = formattedDateTime;
            document.getElementById('end_time').min = formattedDateTime;
            
            // Update end time minimum when start time changes
            document.getElementById('start_time').addEventListener('change', function() {
                document.getElementById('end_time').min = this.value;
            });

            // Trigger room details display for pre-selected room (old input)
            if (roomSelect.value) {
                roomSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
    @endpush
</x-app-layout>
