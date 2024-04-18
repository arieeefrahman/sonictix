<?php

namespace Tests\Feature\Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateEventTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateEventSuccess(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        $event = Event::factory()->create();
        $id = $event->id;

        $requestBody = [
            'title'             => 'Coachella Valley Music and Arts Festival 2024',
            'description'       => 'It is not a dream. It is not a mirage. It is the newest stage joining the desert roster. More artists, extended sets.',
            'start_date'        => '2024-04-17 06:40:18',
            'end_date'          => '2024-04-17 06:40:20',
            'created_by'        => 'California Records',
            'location'          => 'California',
            'google_maps_url'   => 'https://www.google.com/maps/test'
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('PUT', '/api/event/' . $id, $requestBody);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function testUpdateEventNotFound(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        $id = 0;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/event/' . $id);
        
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function testUpdateEventByNonNumericId(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        $id = "non numeric id";

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/event/' . $id);
        
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }
}
