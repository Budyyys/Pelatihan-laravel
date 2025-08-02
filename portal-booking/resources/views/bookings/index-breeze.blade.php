<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Booking Ruang Rapat') }}
        </h2>
    </x-slot>

    <!-- Include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Alert -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Bookings -->
                <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Booking</p>
                                <p class="text-3xl font-bold mt-1">{{ $totalBookings }}</p>
                                <p class="text-blue-200 text-xs mt-2">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    Semua waktu
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-calendar-check text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Bookings -->
                <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-emerald-100 text-sm font-medium">Booking Mendatang</p>
                                <p class="text-3xl font-bold mt-1">{{ $upcomingBookings }}</p>
                                <p class="text-emerald-200 text-xs mt-2">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    Belum berlangsung
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-clock text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Bookings -->
                <div class="bg-gradient-to-br from-amber-500 via-orange-500 to-orange-600 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium">Booking Hari Ini</p>
                                <p class="text-3xl font-bold mt-1">{{ $todayBookings }}</p>
                                <p class="text-orange-200 text-xs mt-2">
                                    <i class="fas fa-calendar-day mr-1"></i>
                                    {{ now()->format('d M Y') }}
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-calendar-day text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6 border border-gray-100">
                <div class="p-6 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-list mr-2 text-blue-600"></i>
                                Daftar Booking
                            </h3>
                            <p class="text-gray-600 mt-1">Kelola semua booking ruang rapat dengan mudah</p>
                        </div>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <div class="flex-1 sm:flex-none relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       id="searchInput" 
                                       placeholder="Cari booking..." 
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm">
                            </div>
                            <button onclick="openCreateForm()" 
                                    class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-lg font-semibold transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-plus mr-2"></i>
                                Buat Booking
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                @if($bookings->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-1"></i>ID
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-user mr-1"></i>Pengguna
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-door-open mr-1"></i>Ruangan
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-heading mr-1"></i>Judul
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-clock mr-1"></i>Waktu
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-calendar mr-1"></i>Dibuat
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-cog mr-1"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($bookings as $booking)
                                        <tr class="hover:bg-blue-50 transition-colors duration-200 group">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    #{{ $booking->id }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                                        <i class="fas fa-user text-white text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-gray-900">{{ $booking->user_name ?? 'N/A' }}</div>
                                                        <div class="text-xs text-gray-500">Peserta booking</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="room-badge inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800 border border-emerald-300" 
                                                      data-room-id="{{ $booking->room_id }}">
                                                    <i class="fas fa-door-open mr-1 text-xs"></i>
                                                    Loading...
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ $booking->title }}</div>
                                                <div class="text-xs text-gray-500 mt-1">Meeting agenda</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="space-y-1">
                                                    <div class="flex items-center text-sm text-gray-900">
                                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}
                                                    </div>
                                                    <div class="flex items-center text-sm text-gray-900">
                                                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-500">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                                        <i class="fas fa-trash mr-1.5"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden">
                        <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                            <h4 class="font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-mobile-alt mr-2 text-blue-600"></i>
                                Tampilan Mobile
                            </h4>
                            <p class="text-sm text-gray-600">Geser untuk melihat detail lengkap</p>
                        </div>
                        @foreach($bookings as $booking)
                            <div class="border-b border-gray-100 p-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                                #{{ $booking->id }}
                                            </span>
                                            <span class="room-badge inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800" 
                                                  data-room-id="{{ $booking->room_id }}">
                                                <i class="fas fa-door-open mr-1"></i>
                                                Loading...
                                            </span>
                                        </div>
                                        <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $booking->title }}</h4>
                                        <p class="text-gray-600 text-sm">Meeting agenda</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-3 mb-4">
                                    <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                        <div class="h-8 w-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $booking->user_name ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-500">Peserta booking</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                        <div class="h-8 w-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-clock text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center text-sm font-semibold text-gray-900 mb-1">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-600">
                                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="h-8 w-8 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-calendar text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                                            <p class="text-xs text-gray-500">Tanggal dibuat</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <i class="fas fa-trash mr-2"></i>
                                        Hapus Booking
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-calendar-times text-4xl text-blue-500"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Booking</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Mulai dengan membuat booking ruang rapat pertama Anda.<br>
                                Sistem siap untuk mengelola jadwal meeting tim Anda.
                            </p>
                            <button onclick="openCreateForm()" 
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <i class="fas fa-plus mr-3"></i>
                                Buat Booking Pertama
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Booking Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm z-50 hidden transition-all duration-300" id="createBookingModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[95vh] overflow-y-auto transform transition-all duration-300 scale-95 modal-content">
                <div class="relative">
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white p-6 rounded-t-2xl relative overflow-hidden">
                        <div class="absolute inset-0 bg-white opacity-10"></div>
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3">
                                    <i class="fas fa-calendar-plus text-xl"></i>
                                </div>
                                Buat Booking Baru
                            </h3>
                            <p class="text-blue-100 mt-2">Isi formulir untuk membuat booking ruang rapat</p>
                        </div>
                        <button class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors duration-200 bg-white bg-opacity-20 rounded-lg p-2" onclick="closeCreateForm()">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('bookings.store') }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label for="user_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-blue-600"></i>
                                    Nama Pengguna
                                </label>
                                <input type="text" id="user_name" name="user_name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                       placeholder="Masukkan nama lengkap" value="{{ old('user_name', Auth::user()->name) }}">
                                @error('user_name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="room_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-door-open mr-2 text-blue-600"></i>
                                    Pilih Ruangan
                                </label>
                                <select id="room_id" name="room_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white">
                                    <option value="">-- Pilih Ruangan --</option>
                                    @if(isset($rooms) && count($rooms) > 0)
                                        @foreach($rooms as $room)
                                            <option value="{{ $room['id'] }}" 
                                                    data-capacity="{{ $room['capacity'] }}"
                                                    data-facilities="{{ $room['facilities'] }}"
                                                    {{ old('room_id') == $room['id'] ? 'selected' : '' }}>
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
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                
                                <div id="room_info" class="mt-3 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 hidden">
                                    <div class="flex items-center text-blue-700">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <span id="room_facilities" class="text-sm font-medium"></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-heading mr-2 text-blue-600"></i>
                                    Judul Booking
                                </label>
                                <input type="text" id="title" name="title" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                       placeholder="Meeting Tim Development" value="{{ old('title') }}">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-play-circle mr-2 text-green-600"></i>
                                        Waktu Mulai
                                    </label>
                                    <input type="datetime-local" id="start_time" name="start_time" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                           value="{{ old('start_time') }}">
                                    @error('start_time')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-stop-circle mr-2 text-red-600"></i>
                                        Waktu Selesai
                                    </label>
                                    <input type="datetime-local" id="end_time" name="end_time" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                           value="{{ old('end_time') }}">
                                    @error('end_time')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-6">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-4 rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Booking
                            </button>
                            <button type="button" onclick="closeCreateForm()" 
                                    class="flex-1 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white py-4 rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Room data from API (passed from PHP)
        const roomsData = @json($rooms ?? []);
        
        function openCreateForm() {
            const modal = document.getElementById('createBookingModal');
            const modalContent = modal.querySelector('.modal-content');
            
            modal.classList.remove('hidden');
            
            // Animate modal appearance
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
            
            // Set minimum date to today
            const today = new Date();
            const todayString = today.toISOString().slice(0, 16);
            document.getElementById('start_time').min = todayString;
            document.getElementById('end_time').min = todayString;
        }
        
        function closeCreateForm() {
            const modal = document.getElementById('createBookingModal');
            const modalContent = modal.querySelector('.modal-content');
            
            // Animate modal disappearance
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
        
        // Handle room selection change
        document.getElementById('room_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const roomInfo = document.getElementById('room_info');
            const facilitiesSpan = document.getElementById('room_facilities');
            
            if (this.value && selectedOption.dataset.facilities) {
                facilitiesSpan.textContent = `Fasilitas: ${selectedOption.dataset.facilities}`;
                roomInfo.classList.remove('hidden');
            } else {
                roomInfo.classList.add('hidden');
            }
        });
        
        // Load room names for existing bookings
        function loadRoomNames() {
            if (roomsData.length === 0) {
                // If no rooms data, show fallback
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
                    badge.title = `Kapasitas: ${room.capacity} orang\nFasilitas: ${room.facilities}`;
                } else {
                    badge.textContent = `Room ${roomId}`;
                    badge.style.opacity = '0.6';
                    badge.title = 'Ruangan tidak ditemukan di sistem';
                }
            });
        }
        
        // Auto-adjust end time when start time changes
        document.getElementById('start_time').addEventListener('change', function() {
            const startTime = new Date(this.value);
            const endTime = new Date(startTime.getTime() + (60 * 60 * 1000)); // Add 1 hour
            document.getElementById('end_time').min = this.value;
            
            if (!document.getElementById('end_time').value) {
                document.getElementById('end_time').value = endTime.toISOString().slice(0, 16);
            }
        });
        
        // Enhanced search functionality for both desktop and mobile
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            // Search in desktop table
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Search in mobile cards
            const mobileCards = document.querySelectorAll('.md\\:hidden > div');
            mobileCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Close modal when clicking outside
        document.getElementById('createBookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateForm();
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
