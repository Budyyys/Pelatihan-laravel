<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Proyektor',
                'icon' => 'fas fa-video',
                'color' => '#3b82f6',
                'description' => 'Proyektor LCD untuk presentasi',
                'is_active' => true,
            ],
            [
                'name' => 'Air Conditioner (AC)',
                'icon' => 'fas fa-snowflake',
                'color' => '#06b6d4',
                'description' => 'Pendingin ruangan',
                'is_active' => true,
            ],
            [
                'name' => 'Whiteboard',
                'icon' => 'fas fa-chalkboard',
                'color' => '#10b981',
                'description' => 'Papan tulis putih',
                'is_active' => true,
            ],
            [
                'name' => 'Sound System',
                'icon' => 'fas fa-volume-up',
                'color' => '#f59e0b',
                'description' => 'Sistem audio untuk presentasi',
                'is_active' => true,
            ],
            [
                'name' => 'WiFi',
                'icon' => 'fas fa-wifi',
                'color' => '#8b5cf6',
                'description' => 'Koneksi internet nirkabel',
                'is_active' => true,
            ],
            [
                'name' => 'Monitor/TV',
                'icon' => 'fas fa-tv',
                'color' => '#ef4444',
                'description' => 'Monitor atau TV untuk tampilan',
                'is_active' => true,
            ],
            [
                'name' => 'Meja',
                'icon' => 'fas fa-table',
                'color' => '#6b7280',
                'description' => 'Meja untuk rapat atau bekerja',
                'is_active' => true,
            ],
            [
                'name' => 'Kursi',
                'icon' => 'fas fa-chair',
                'color' => '#92400e',
                'description' => 'Kursi untuk peserta',
                'is_active' => true,
            ],
            [
                'name' => 'Microphone',
                'icon' => 'fas fa-microphone',
                'color' => '#db2777',
                'description' => 'Mikrofon untuk presentasi',
                'is_active' => true,
            ],
            [
                'name' => 'Flip Chart',
                'icon' => 'fas fa-clipboard',
                'color' => '#059669',
                'description' => 'Papan flip chart untuk presentasi',
                'is_active' => true,
            ],
        ];

        foreach ($facilities as $facility) {
            \App\Models\Facility::create($facility);
        }
    }
}
