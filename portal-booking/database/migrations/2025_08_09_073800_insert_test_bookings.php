<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Insert test booking data
        DB::table('bookings')->insert([
            [
                'user_id' => 1,
                'user_name' => 'John Doe',
                'room_id' => 1,
                'title' => 'Morning Meeting',
                'start_time' => '2025-08-10 09:00:00',
                'end_time' => '2025-08-10 10:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'user_name' => 'Jane Smith',
                'room_id' => 2,
                'title' => 'Team Standup',
                'start_time' => '2025-08-10 14:00:00',
                'end_time' => '2025-08-10 15:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        DB::table('bookings')
            ->whereIn('title', ['Morning Meeting', 'Team Standup'])
            ->delete();
    }
};
