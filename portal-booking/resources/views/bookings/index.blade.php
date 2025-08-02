<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Booking Ruang Rapat
                </h2>
                <p class="text-sm text-gray-600 mt-1">Kelola reservasi ruang meeting dengan mudah</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                <button onclick="openCreateForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    + Buat Booking
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Success Alert -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Simple Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</div>
                    <div class="text-sm text-gray-600">Total Booking</div>
                </div>
                <div class="bg-white p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $upcomingBookings }}</div>
                    <div class="text-sm text-gray-600">Booking Mendatang</div>
                </div>
                <div class="bg-white p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $todayBookings }}</div>
                    <div class="text-sm text-gray-600">Booking Hari Ini</div>
                </div>
            </div>

            <!-- Search and List Header -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Booking</h3>
                    <div class="flex items-center space-x-3">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Cari booking..." 
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                        <button onclick="openCreateForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            + Tambah
                        </button>
                    </div>
                </div>
            </div>

            <!-- Simple Table -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                @if($bookings->count() > 0)
                    <!-- Desktop View -->
                    <div class="hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($bookings as $booking)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900">#{{ $booking->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->user_name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="room-badge text-sm text-gray-900" data-room-id="{{ $booking->room_id }}">
                                                Loading...
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->title }}</div>
                                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                sampai {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden">
                        @foreach($bookings as $booking)
                            <div class="p-4 border-b border-gray-200 last:border-b-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="font-medium text-gray-900">{{ $booking->title }}</div>
                                    <span class="text-sm text-gray-500">#{{ $booking->id }}</span>
                                </div>
                                <div class="text-sm text-gray-600 space-y-1">
                                    <div>{{ $booking->user_name ?? 'N/A' }}</div>
                                    <div class="room-badge" data-room-id="{{ $booking->room_id }}">Loading...</div>
                                    <div>{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</div>
                                </div>
                                <div class="mt-3 text-right">
                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus booking ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Simple Empty State -->
                    <div class="text-center py-12">
                        <p class="text-gray-500 mb-4">Belum ada booking</p>
                        <button onclick="openCreateForm()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            + Buat Booking Pertama
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Simple Create Booking Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" id="createBookingModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg w-full max-w-md">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Buat Booking Baru</h3>
                        <button type="button" onclick="closeCreateForm()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('bookings.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    
                    <div>
                        <label for="user_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                        <input type="text" id="user_name" name="user_name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama lengkap" value="{{ old('user_name', Auth::user()->name) }}">
                        @error('user_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Ruangan</label>
                        <select id="room_id" name="room_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Ruangan --</option>
                            @if(isset($rooms) && count($rooms) > 0)
                                @foreach($rooms as $room)
                                    <option value="{{ $room['id'] }}" {{ old('room_id') == $room['id'] ? 'selected' : '' }}>
                                        {{ $room['name'] }} ({{ $room['capacity'] }} orang)
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
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Meeting Tim Development" value="{{ old('title') }}">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                            <input type="datetime-local" id="start_time" name="start_time" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('start_time') }}">
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                            <input type="datetime-local" id="end_time" name="end_time" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('end_time') }}">
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3 pt-4">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                            Simpan Booking
                        </button>
                        <button type="button" onclick="closeCreateForm()" 
                                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-lg font-medium transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Room data from API
        const roomsData = @json($rooms ?? []);
        
        function openCreateForm() {
            document.getElementById('createBookingModal').classList.remove('hidden');
            
            // Set minimum date to today
            const today = new Date();
            const todayString = today.toISOString().slice(0, 16);
            document.getElementById('start_time').min = todayString;
            document.getElementById('end_time').min = todayString;
        }
        
        function closeCreateForm() {
            document.getElementById('createBookingModal').classList.add('hidden');
        }
        
        // Load room names
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
                }
            });
        }
        
        // Auto-adjust end time
        document.getElementById('start_time').addEventListener('change', function() {
            const startTime = new Date(this.value);
            const endTime = new Date(startTime.getTime() + (60 * 60 * 1000));
            document.getElementById('end_time').min = this.value;
            
            if (!document.getElementById('end_time').value) {
                document.getElementById('end_time').value = endTime.toISOString().slice(0, 16);
            }
        });
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            // Desktop table
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
            
            // Mobile cards
            const mobileCards = document.querySelectorAll('.md\\:hidden > div');
            mobileCards.forEach(card => {
                if (card.classList.contains('p-4')) {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(searchTerm) ? '' : 'none';
                }
            });
        });
        
        // Close modal on outside click
        document.getElementById('createBookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateForm();
            }
        });
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadRoomNames();
        });

        // Show modal if validation errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openCreateForm();
            });
        @endif
    </script>
</x-app-layout>
