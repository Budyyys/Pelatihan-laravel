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
                                @if(isset($rooms) && count($rooms) > 0)
                                    @foreach($rooms as $room)
                                        <option value="{{ $room['id'] }}" {{ old('room_id', $booking->room_id) == $room['id'] ? 'selected' : '' }}>
                                            {{ $room['name'] }} (Kapasitas: {{ $room['capacity'] }} orang)
                                        </option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('room_id', $booking->room_id) == '1' ? 'selected' : '' }}>Ruang Meeting A</option>
                                    <option value="2" {{ old('room_id', $booking->room_id) == '2' ? 'selected' : '' }}>Ruang Meeting B</option>
                                    <option value="3" {{ old('room_id', $booking->room_id) == '3' ? 'selected' : '' }}>Ruang Seminar</option>
                                @endif
                            </select>
                            @error('room_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
</x-app-layout>
