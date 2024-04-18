<?php

namespace Tests\Feature\Event;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetEventsTest extends TestCase
{
    use RefreshDatabase;
    
    public function testGetEventsSuccess(): void
    {
        $user = User::factory()->create();

        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/events');
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }
}
