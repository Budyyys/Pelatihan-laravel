<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for authentication testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'name' => 'Admin Booking',
            'email' => 'admin@booking.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->info("Test user created successfully!");
        $this->info("Email: admin@booking.com");
        $this->info("Password: password");

        return 0;
    }
}
