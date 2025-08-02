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
                                        @if(isset($room['capacity']))
                                            (Kapasitas: {{ $room['capacity'] }} orang)
                                        @endif
                                        @if(isset($room['facilities']))
                                            - {{ $room['facilities'] }}
                                        @endif
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
        // Set minimum datetime to current time
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const formattedDateTime = now.toISOString().slice(0, 16);
            
            document.getElementById('start_time').min = formattedDateTime;
            document.getElementById('end_time').min = formattedDateTime;
            
            // Update end time minimum when start time changes
            document.getElementById('start_time').addEventListener('change', function() {
                document.getElementById('end_time').min = this.value;
            });
        });
    </script>
    @endpush
</x-app-layout>
