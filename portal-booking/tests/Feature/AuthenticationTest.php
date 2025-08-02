<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_bookings_requires_authentication()
    {
        $response = $this->get('/bookings');
        
        // Should redirect to login
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_bookings()
    {
        $user = \App\Models\User::factory()->create();
        
        $response = $this->actingAs($user)->get('/bookings');
        
        // Should be successful
        $response->assertOk();
    }
}
