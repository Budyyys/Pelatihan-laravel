<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create rooms
        $rooms = [
            [
                'name' => 'Meeting Room A',
                'capacity' => 10,
                'facilities' => [
                    ['id' => 1, 'quantity' => 1], // Proyektor
                    ['id' => 2, 'quantity' => 1], // AC
                    ['id' => 5, 'quantity' => 1], // WiFi
                    ['id' => 7, 'quantity' => 1], // Meja
                    ['id' => 8, 'quantity' => 10], // Kursi
                ]
            ],
            [
                'name' => 'Conference Room B',
                'capacity' => 20,
                'facilities' => [
                    ['id' => 1, 'quantity' => 1], // Proyektor
                    ['id' => 2, 'quantity' => 1], // AC
                    ['id' => 3, 'quantity' => 1], // Whiteboard
                    ['id' => 4, 'quantity' => 1], // Sound System
                    ['id' => 5, 'quantity' => 1], // WiFi
                    ['id' => 6, 'quantity' => 1], // Monitor/TV
                    ['id' => 7, 'quantity' => 4], // Meja
                    ['id' => 8, 'quantity' => 20], // Kursi
                    ['id' => 9, 'quantity' => 2], // Microphone
                ]
            ],
            [
                'name' => 'Training Room C',
                'capacity' => 15,
                'facilities' => [
                    ['id' => 1, 'quantity' => 1], // Proyektor
                    ['id' => 2, 'quantity' => 1], // AC
                    ['id' => 4, 'quantity' => 1], // Sound System
                    ['id' => 5, 'quantity' => 1], // WiFi
                    ['id' => 7, 'quantity' => 6], // Meja
                    ['id' => 8, 'quantity' => 15], // Kursi
                    ['id' => 10, 'quantity' => 1], // Flip Chart
                ]
            ],
            [
                'name' => 'Discussion Room D',
                'capacity' => 6,
                'facilities' => [
                    ['id' => 2, 'quantity' => 1], // AC
                    ['id' => 3, 'quantity' => 1], // Whiteboard
                    ['id' => 5, 'quantity' => 1], // WiFi
                    ['id' => 7, 'quantity' => 1], // Meja
                    ['id' => 8, 'quantity' => 6], // Kursi
                ]
            ],
            [
                'name' => 'Executive Room E',
                'capacity' => 8,
                'facilities' => [
                    ['id' => 1, 'quantity' => 1], // Proyektor
                    ['id' => 2, 'quantity' => 1], // AC
                    ['id' => 4, 'quantity' => 1], // Sound System
                    ['id' => 5, 'quantity' => 1], // WiFi
                    ['id' => 6, 'quantity' => 1], // Monitor/TV
                    ['id' => 7, 'quantity' => 1], // Meja
                    ['id' => 8, 'quantity' => 8], // Kursi
                    ['id' => 9, 'quantity' => 1], // Microphone
                ]
            ],
        ];

        foreach ($rooms as $roomData) {
            $room = \App\Models\Room::create([
                'name' => $roomData['name'],
                'capacity' => $roomData['capacity'],
            ]);

            // Attach facilities
            foreach ($roomData['facilities'] as $facility) {
                $room->facilities()->attach($facility['id'], [
                    'quantity' => $facility['quantity'],
                    'notes' => null
                ]);
            }
        }
    }
}
