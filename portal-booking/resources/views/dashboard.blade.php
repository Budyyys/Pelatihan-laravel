<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Booking Ruang Rapat') }}
        </h2>
    </x-slot>

    <style>
        .booking-card {
            transition: all 0.3s ease;
        }
        .booking-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .create-btn {
            background: linear-gradient(135deg, #FF7D29 0%, #e66a1f 100%);
            transition: all 0.3s ease;
        }
        .create-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 125, 41, 0.4);
        }
        
        .room-option-available {
            background-color: #dcfce7 !important;
            color: #166534 !important;
            border-bottom: 1px solid #bbf7d0 !important;
            padding: 8px 12px !important;
        }
        
        .room-option-busy {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
            border-bottom: 1px solid #fecaca !important;
            padding: 8px 12px !important;
        }
        
        .room-option-maintenance {
            background-color: #fef3c7 !important;
            color: #92400e !important;
            border-bottom: 1px solid #fed7aa !important;
            padding: 8px 12px !important;
        }
        
        .room-option-default {
            background-color: #f3f4f6 !important;
            color: #374151 !important;
            border-bottom: 1px solid #d1d5db !important;
            padding: 8px 12px !important;
        }

        /* Enhanced Room Select Dropdown */
        #room_id {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        /* Dropdown Options Styling */
        #room_id option {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            line-height: 1.5;
            font-size: 14px;
        }

        #room_id option:first-child {
            background-color: #f9fafb !important;
            color: #6b7280 !important;
            font-style: italic;
            border-bottom: 2px solid #d1d5db !important;
        }

        #room_id option:last-child {
            border-bottom: none !important;
        }

        #room_id option:hover {
            background-color: #f3f4f6 !important;
        }

        #room_id option:disabled {
            background-color: #f3f4f6 !important;
            color: #9ca3af !important;
            opacity: 0.6;
        }

        /* Room Details Box */
        .room-details-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.3s ease-out;
            max-height: 300px;
            overflow-y: auto;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .room-details-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-weight: 600;
            color: #374151;
            font-size: 12px;
        }

        .room-details-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .room-detail-item {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            background: #f9fafb;
            border-radius: 6px;
            font-size: 11px;
            border: 1px solid #f3f4f6;
        }

        .room-detail-item i {
            margin-right: 8px;
            width: 14px;
            text-align: center;
            color: #6b7280;
        }

        /* Enhanced styling for form components */
        .form-component {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .form-component:hover {
            border-color: #d1d5db;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .icon-container {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .capacity-indicator {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-left: 8px;
        }
        
        .facility-tag {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 0.7rem;
            margin-right: 4px;
        }
        
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-available { background-color: #10b981; }
        .status-busy { background-color: #ef4444; }
        .status-maintenance { background-color: #f59e0b; }
        .status-default { background-color: #6b7280; }
        
        #room-details {
            transition: all 0.3s ease-in-out;
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .room-select-container select {
            transition: border-color 0.3s ease;
        }
        
        .room-select-container select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Modal Structure Fix */
        .popup-overlay {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popup-overlay.hidden {
            display: none !important;
        }

        /* Ensure button is always visible */
        .modal-footer-fixed {
            position: relative;
            z-index: 10;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        /* Enhance button visibility */
        .submit-button-enhanced {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
            border: 2px solid #ea580c !important;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3) !important;
            font-weight: 800 !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) !important;
        }

        .submit-button-enhanced:hover {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%) !important;
            box-shadow: 0 6px 16px rgba(234, 88, 12, 0.4) !important;
            transform: translateY(-1px) scale(1.02) !important;
        }

        /* Scroll improvements */
        .modal-content-scroll {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f3f4f6;
        }

        .modal-content-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content-scroll::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }

        .modal-content-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .modal-content-scroll::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Mobile responsive improvements */
        @media (max-width: 640px) {
            .popup-overlay .bg-white {
                max-height: 95vh !important;
                margin: 0.5rem !important;
            }
            
            .modal-footer-fixed {
                padding: 1rem !important;
            }
            
            .submit-button-enhanced {
                padding: 0.875rem 1.5rem !important;
                font-size: 1rem !important;
            }
        }

        /* Ensure modal doesn't exceed viewport */
        .modal-container {
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        /* Button pulse animation for better visibility */
        @keyframes buttonPulse {
            0% { box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3); }
            50% { box-shadow: 0 6px 20px rgba(249, 115, 22, 0.5); }
            100% { box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3); }
        }

        .submit-button-enhanced {
            animation: buttonPulse 2s infinite;
        }

        .submit-button-enhanced:hover {
            animation: none !important;
        }

        /* Alert System Styles */
        .alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            pointer-events: none;
        }

        .alert-container {
            display: flex;
            justify-content: center;
            padding: 1rem;
            pointer-events: none;
        }

        .alert-box {
            max-width: 600px;
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 500;
            font-size: 14px;
            line-height: 1.5;
            animation: slideInDown 0.4s ease-out;
            pointer-events: auto;
            position: relative;
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .alert-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .alert-conflict {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .alert-icon {
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-size: 15px;
        }

        .alert-message {
            opacity: 0.95;
            font-size: 13px;
        }

        .alert-close {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .alert-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideOutUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-100px);
            }
        }

        .alert-box.hiding {
            animation: slideOutUp 0.3s ease-in forwards;
        }

        /* Progress bar for auto-dismiss */
        .alert-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 0 0 12px 12px;
            animation: alertProgress 5s linear forwards;
        }

        @keyframes alertProgress {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>

    <div class="py-8">
        <!-- Alert System -->
        <div class="alert-overlay" id="alertOverlay" style="display: none;">
            <div class="alert-container">
                <div class="alert-box" id="alertBox">
                    <div class="alert-icon" id="alertIcon"></div>
                    <div class="alert-content">
                        <div class="alert-title" id="alertTitle"></div>
                        <div class="alert-message" id="alertMessage"></div>
                    </div>
                    <button class="alert-close" onclick="hideAlert()">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="alert-progress" id="alertProgress"></div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-600 mt-1">Kelola dan pantau semua booking ruang rapat dengan mudah</p>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-calendar-alt text-4xl text-blue-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="stat-card rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold">Total Booking</h4>
                            <p class="text-3xl font-bold">{{ $totalBookings ?? 0 }}</p>
                        </div>
                        <div class="text-4xl opacity-80">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold">Booking Mendatang</h4>
                            <p class="text-3xl font-bold">{{ $upcomingBookings ?? 0 }}</p>
                        </div>
                        <div class="text-4xl opacity-80">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold">Booking Hari Ini</h4>
                            <p class="text-3xl font-bold">{{ $todayBookings ?? 0 }}</p>
                        </div>
                        <div class="text-4xl opacity-80">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">Aksi Cepat</h4>
                            <p class="text-gray-600">Buat booking baru atau kelola booking yang ada</p>
                        </div>
                        <div class="flex gap-3">
                            <button onclick="openCreateForm()" class="create-btn text-white px-6 py-3 rounded-lg font-semibold">
                                <i class="fas fa-plus mr-2"></i>
                                Buat Booking Baru
                            </button>
                            <a href="{{ route('bookings.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                <i class="fas fa-list mr-2"></i>
                                Lihat Semua Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Booking Terbaru</h4>
                    
                    @if(isset($recentBookings) && $recentBookings->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($recentBookings as $booking)
                                <div class="booking-card border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <h5 class="font-semibold text-gray-800">{{ $booking->title }}</h5>
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            Room {{ $booking->room_id }}
                                        </span>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p><i class="fas fa-user mr-2"></i>{{ $booking->user_name }}</p>
                                        <p><i class="fas fa-clock mr-2"></i>{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}</p>
                                        <p><i class="fas fa-calendar mr-2"></i>{{ $booking->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                Lihat Semua Booking →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                            <h5 class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Booking</h5>
                            <p class="text-gray-500 mb-4">Mulai dengan membuat booking ruang rapat pertama Anda</p>
                            <button onclick="openCreateForm()" class="create-btn text-white px-6 py-3 rounded-lg font-semibold">
                                <i class="fas fa-plus mr-2"></i>
                                Buat Booking Pertama
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <div class="popup-overlay fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden" id="createBookingModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col modal-container">
                <!-- Header Modal - Fixed -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 rounded-t-xl flex justify-between items-center flex-shrink-0">
                    <h3 class="text-lg font-bold">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Buat Booking Ruang Rapat
                    </h3>
                    <button class="text-white hover:text-gray-200 text-xl" onclick="closeCreateForm()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Content Modal - Scrollable -->
                <div class="flex-1 overflow-y-auto p-6 modal-content-scroll">
                    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm" novalidate>
                        @csrf
                        
                        <div class="space-y-4">
                            <div>
                                <label for="user_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>Nama Pengguna
                                </label>
                                <input type="text" id="user_name" name="user_name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Masukkan nama" value="{{ old('user_name', Auth::user()->name) }}">
                                <div id="user_name_error" class="text-red-600 text-xs mt-1"></div>
                            </div>

                            <div class="room-select-container">
                                <label for="room_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-door-open mr-2"></i>Pilih Ruangan
                                </label>
                                <select id="room_id" name="room_id" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">-- Pilih Ruangan --</option>
                                    @forelse($rooms as $room)
                                        @php
                                            $statusClass = 'room-option-default';
                                            $statusText = 'Tersedia';
                                            if(isset($room['status'])) {
                                                switch($room['status']) {
                                                    case 'available':
                                                        $statusClass = 'room-option-available';
                                                        $statusText = 'Tersedia';
                                                        break;
                                                    case 'busy':
                                                        $statusClass = 'room-option-busy';
                                                        $statusText = 'Sedang Digunakan';
                                                        break;
                                                    case 'maintenance':
                                                        $statusClass = 'room-option-maintenance';
                                                        $statusText = 'Maintenance';
                                                        break;
                                                }
                                            }
                                        @endphp
                                        <option value="{{ $room['id'] }}" 
                                                class="{{ $statusClass }}"
                                                data-capacity="{{ $room['capacity'] ?? 'N/A' }}"
                                                data-facilities="{{ json_encode($room['facilities'] ?? []) }}"
                                                data-facilities-text="{{ $room['facilities_text'] ?? '' }}"
                                                data-status="{{ $room['status'] ?? 'available' }}"
                                                {{ old('room_id') == $room['id'] ? 'selected' : '' }}
                                                {{ isset($room['status']) && $room['status'] === 'busy' ? 'disabled' : '' }}>
                                            🏠 {{ $room['name'] }}
                                            @if(isset($room['capacity']))
                                                (👥{{ $room['capacity'] }})
                                            @endif
                                            - {{ $statusText }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada ruangan tersedia</option>
                                    @endforelse
                                </select>
                                 <div id="room_id_error" class="text-red-600 text-xs mt-1"></div>
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-heading mr-2"></i>Judul Meeting
                                </label>
                                <input type="text" id="title" name="title" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Contoh: Meeting Tim Development" value="{{ old('title') }}">
                                <div id="title_error" class="text-red-600 text-xs mt-1"></div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-clock mr-2"></i>Jadwal Meeting
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_time" class="block text-xs text-gray-600 mb-1">Waktu Mulai</label>
                                        <input type="datetime-local" id="start_time" name="start_time" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               value="{{ old('start_time') }}">
                                        <div id="start_time_error" class="text-red-600 text-xs mt-1"></div>
                                    </div>
                                    
                                    <div>
                                        <label for="end_time" class="block text-xs text-gray-600 mb-1">Waktu Selesai</label>
                                        <input type="datetime-local" id="end_time" name="end_time" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               value="{{ old('end_time') }}">
                                        <div id="end_time_error" class="text-red-600 text-xs mt-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer Modal - Fixed -->
                <div class="bg-gray-50 p-4 rounded-b-xl border-t border-gray-200 flex-shrink-0 modal-footer-fixed">
                    <div class="flex flex-col gap-3">
                        <button type="submit" form="bookingForm" 
                                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 px-6 rounded-lg font-bold text-lg uppercase tracking-wider transform hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2 shadow-lg submit-button-enhanced">
                            <span>🚀</span>
                            <span>Kirim Booking</span>
                        </button>
                        <button type="button" onclick="closeCreateForm()" 
                                class="w-full bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg font-semibold transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openCreateForm() {
            const modal = document.getElementById('createBookingModal');
            modal.classList.remove('hidden');
            
            const today = new Date();
            const todayString = today.toISOString().slice(0, 16);
            document.getElementById('start_time').min = todayString;
            document.getElementById('end_time').min = todayString;
            
            initializeRoomSelection();
        }
        
        function closeCreateForm() {
            const modal = document.getElementById('createBookingModal');
            modal.classList.add('hidden');
            
            const form = document.getElementById('bookingForm');
            form.reset();

            // Reset error messages and styles
             const fieldsToValidate = ['user_name', 'room_id', 'title', 'start_time', 'end_time'];
             fieldsToValidate.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                const errorDiv = document.getElementById(`${fieldId}_error`);
                field.classList.remove('border-red-500');
                field.classList.add('border-gray-300');
                if (errorDiv) {
                    errorDiv.textContent = '';
                }
            });

            clearRoomDetails();
        }
        
        function initializeRoomSelection() {
            const roomSelect = document.getElementById('room_id');
            
            roomSelect.addEventListener('change', function() {
                showRoomDetails(this.value, this.selectedOptions[0].text);
            });
            
            if (roomSelect.value) {
                showRoomDetails(roomSelect.value, roomSelect.selectedOptions[0].text);
            }
        }
        
        function showRoomDetails(roomId, roomText) {
            clearRoomDetails();
            
            if (roomId) {
                const roomSelect = document.getElementById('room_id');
                const selectedOption = roomSelect.selectedOptions[0];
                
                const capacity = selectedOption.getAttribute('data-capacity') || 'N/A';
                const facilitiesData = selectedOption.getAttribute('data-facilities') || '';
                const facilitiesText = selectedOption.getAttribute('data-facilities-text') || '';
                const status = selectedOption.getAttribute('data-status') || 'available';
                
                let facilitiesList = [];
                if (facilitiesData) {
                    try {
                        facilitiesList = JSON.parse(facilitiesData);
                    } catch (e) {
                        console.log('Failed to parse facilities JSON, using fallback');
                        facilitiesList = [];
                    }
                }
                
                // If facilities array is empty but facilities_text exists, parse it
                if (facilitiesList.length === 0 && facilitiesText) {
                    facilitiesList = facilitiesText.split(',').map(f => ({
                        name: f.trim(),
                        icon: 'fas fa-star',
                        color: '#0ea5e9'
                    })).filter(f => f.name);
                }
                
                let statusInfo = { text: 'Tersedia', icon: 'check-circle', color: '#10b981' };
                switch(status) {
                    case 'available': statusInfo = { text: 'Tersedia', icon: 'check-circle', color: '#10b981' }; break;
                    case 'busy': statusInfo = { text: 'Sedang Digunakan', icon: 'times-circle', color: '#ef4444' }; break;
                    case 'maintenance': statusInfo = { text: 'Maintenance', icon: 'tools', color: '#f59e0b' }; break;
                    default: statusInfo = { text: 'Tersedia', icon: 'check-circle', color: '#10b981' }; break;
                }
                
                const detailsDiv = document.createElement('div');
                detailsDiv.id = 'room-details';
                detailsDiv.className = 'room-details-box';
                
                let facilitiesHtml = '';
                if (facilitiesList.length > 0) {
                    facilitiesHtml = `
                        <div class="room-detail-item" style="align-items: flex-start; grid-column: 1 / -1;">
                            <i class="fas fa-cogs"></i>
                            <div>
                                <strong>Fasilitas:</strong>
                                <div style="margin-top: 6px; display: flex; flex-wrap: wrap; gap: 6px;">
                                    ${facilitiesList.map(f => `
                                        <span style="background: ${f.color || '#0ea5e9'}; color: white; padding: 4px 10px; border-radius: 16px; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="${f.icon || 'fas fa-star'}" style="font-size: 10px;"></i>
                                            ${f.name}
                                            ${f.quantity && f.quantity > 1 ? ` (${f.quantity})` : ''}
                                        </span>
                                    `).join('')}
                                </div>
                            </div>
                        </div>`;
                } else {
                    facilitiesHtml = `
                        <div class="room-detail-item">
                            <i class="fas fa-info-circle"></i>
                            <span><strong>Fasilitas:</strong> Informasi tidak tersedia</span>
                        </div>`;
                }
                
                detailsDiv.innerHTML = `
                    <div class="room-details-header">
                        <i class="fas fa-info-circle mr-2" style="color: #0ea5e9;"></i>
                        <span>Detail Ruangan Terpilih</span>
                    </div>
                    <div class="room-details-content">
                        <div class="room-detail-item"><i class="fas fa-door-open"></i><span><strong>Nama:</strong> ${roomText.split(' - ')[0]}</span></div>
                        <div class="room-detail-item"><i class="fas fa-users"></i><span><strong>Kapasitas:</strong> ${capacity} orang</span></div>
                        <div class="room-detail-item"><i class="fas fa-${statusInfo.icon}" style="color: ${statusInfo.color};"></i><span><strong>Status:</strong> ${statusInfo.text}</span></div>
                        ${facilitiesHtml}
                    </div>`;
                
                roomSelect.parentNode.insertBefore(detailsDiv, roomSelect.nextSibling);
            }
        }
        
        function clearRoomDetails() {
            const existingDetails = document.getElementById('room-details');
            if (existingDetails) {
                existingDetails.remove();
            }
        }
        
        document.getElementById('start_time').addEventListener('change', function() {
            const startTime = new Date(this.value);
            const endTime = new Date(startTime.getTime() + (60 * 60 * 1000)); // Add 1 hour
            document.getElementById('end_time').min = this.value;
            
            if (!document.getElementById('end_time').value || new Date(document.getElementById('end_time').value) < startTime) {
                document.getElementById('end_time').value = endTime.toISOString().slice(0, 16);
            }
        });
        
        function validateBookingForm() {
            let isValid = true;
            let firstErrorField = null;
            const fieldsToValidate = ['user_name', 'room_id', 'title', 'start_time', 'end_time'];

            fieldsToValidate.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                const errorDiv = document.getElementById(`${fieldId}_error`);
                field.classList.remove('border-red-500');
                field.classList.add('border-gray-300');
                if (errorDiv) errorDiv.textContent = '';
            });

            fieldsToValidate.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    const errorDiv = document.getElementById(`${fieldId}_error`);
                    field.classList.add('border-red-500');
                    if (errorDiv) errorDiv.textContent = 'Kolom ini wajib diisi.';
                    if (!firstErrorField) firstErrorField = field;
                    isValid = false;
                }
            });

            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (startTime && endTime) {
                const start = new Date(startTime);
                const end = new Date(endTime);
                
                if (end <= start) {
                    const errorDiv = document.getElementById('end_time_error');
                    endTimeInput.classList.add('border-red-500');
                    errorDiv.textContent = 'Waktu selesai harus setelah waktu mulai.';
                    if (!firstErrorField) firstErrorField = endTimeInput;
                    isValid = false;
                }
                
                const now = new Date();
                now.setMinutes(now.getMinutes() - 1); 

                if (start < now) {
                    const errorDiv = document.getElementById('start_time_error');
                    startTimeInput.classList.add('border-red-500');
                    errorDiv.textContent = 'Tidak dapat booking untuk waktu yang sudah lewat.';
                    if (!firstErrorField) firstErrorField = startTimeInput;
                    isValid = false;
                }
            }
            
            if (!isValid && firstErrorField) {
                firstErrorField.focus();
            }
            
            return isValid;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bookingForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateBookingForm()) {
                        e.preventDefault();
                    }
                });
            }
        });
        
        document.getElementById('createBookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateForm();
            }
        });

        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openCreateForm();
            });
        @endif

        // Alert System Functions
        function showAlert(type, title, message, autoHide = true) {
            const overlay = document.getElementById('alertOverlay');
            const box = document.getElementById('alertBox');
            const icon = document.getElementById('alertIcon');
            const titleElement = document.getElementById('alertTitle');
            const messageElement = document.getElementById('alertMessage');
            const progress = document.getElementById('alertProgress');

            // Reset classes
            box.className = 'alert-box';
            
            // Set type-specific styling and icons
            switch (type) {
                case 'success':
                    box.classList.add('alert-success');
                    icon.innerHTML = '<i class="fas fa-check"></i>';
                    break;
                case 'error':
                case 'conflict':
                    box.classList.add(type === 'error' ? 'alert-error' : 'alert-conflict');
                    icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
                    break;
                default:
                    box.classList.add('alert-success');
                    icon.innerHTML = '<i class="fas fa-info"></i>';
            }

            // Set content
            titleElement.textContent = title;
            messageElement.textContent = message;

            // Show alert
            overlay.style.display = 'block';
            
            // Remove any existing progress bar animation
            progress.style.animation = 'none';
            progress.offsetHeight; // Force reflow
            
            if (autoHide) {
                progress.style.animation = 'alertProgress 5s linear forwards';
                setTimeout(() => {
                    hideAlert();
                }, 5000);
            } else {
                progress.style.display = 'none';
            }
        }

        function hideAlert() {
            const overlay = document.getElementById('alertOverlay');
            const box = document.getElementById('alertBox');
            
            box.classList.add('hiding');
            
            setTimeout(() => {
                overlay.style.display = 'none';
                box.classList.remove('hiding');
            }, 300);
        }

        // Show alerts based on Laravel session data
        document.addEventListener('DOMContentLoaded', function() {
            // Add close button event listener
            const closeBtn = document.getElementById('alertClose');
            if (closeBtn) {
                closeBtn.addEventListener('click', hideAlert);
            }

            // Check for Laravel session alerts
            @if(session('success'))
                showAlert('success', 'Berhasil!', '{{ session("success") }}');
            @endif

            @if($errors->has('schedule'))
                showAlert('conflict', 'Jadwal Bentrok!', '{{ $errors->first("schedule") }}', false);
            @endif

            @if($errors->any() && !$errors->has('schedule'))
                const errorMessages = [
                    @foreach($errors->all() as $error)
                        '{{ $error }}',
                    @endforeach
                ];
                showAlert('error', 'Kesalahan Input', errorMessages.join(' '), false);
            @endif
        });

        // Enhanced form validation with better error display
        function validateBookingForm() {
            let isValid = true;
            let firstErrorField = null;
            let errorMessages = [];
            const fieldsToValidate = ['user_name', 'room_id', 'title', 'start_time', 'end_time'];

            fieldsToValidate.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                const errorDiv = document.getElementById(`${fieldId}_error`);
                field.classList.remove('border-red-500');
                field.classList.add('border-gray-300');
                if (errorDiv) errorDiv.textContent = '';
            });

            fieldsToValidate.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    const errorDiv = document.getElementById(`${fieldId}_error`);
                    const fieldName = field.previousElementSibling.textContent.replace('*', '').trim();
                    const message = `${fieldName} wajib diisi`;
                    
                    field.classList.add('border-red-500');
                    if (errorDiv) errorDiv.textContent = message;
                    errorMessages.push(message);
                    if (!firstErrorField) firstErrorField = field;
                    isValid = false;
                }
            });

            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (startTime && endTime) {
                const start = new Date(startTime);
                const end = new Date(endTime);
                
                if (end <= start) {
                    const errorDiv = document.getElementById('end_time_error');
                    const message = 'Waktu selesai harus setelah waktu mulai';
                    endTimeInput.classList.add('border-red-500');
                    errorDiv.textContent = message;
                    errorMessages.push(message);
                    if (!firstErrorField) firstErrorField = endTimeInput;
                    isValid = false;
                }
                
                const now = new Date();
                now.setMinutes(now.getMinutes() - 1); 

                if (start < now) {
                    const errorDiv = document.getElementById('start_time_error');
                    const message = 'Tidak dapat booking untuk waktu yang sudah lewat';
                    startTimeInput.classList.add('border-red-500');
                    errorDiv.textContent = message;
                    errorMessages.push(message);
                    if (!firstErrorField) firstErrorField = startTimeInput;
                    isValid = false;
                }
            }
            
            if (!isValid) {
                showAlert('error', 'Kesalahan Input', errorMessages.join('. '), false);
                if (firstErrorField) {
                    firstErrorField.focus();
                }
            }
            
            return isValid;
        }
    </script>
</x-app-layout>