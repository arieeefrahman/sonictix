<?php

namespace Tests\Feature\Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEventTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteEventSuccess(): void
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

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/event/' . $id);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function testDeleteEventByIdNotFound(): void
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
        ])->delete('/api/event/' . $id);
        
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function testDeleteEventByNonNumericId(): void
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
        ])->delete('/api/event/' . $id);
        
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }
}
