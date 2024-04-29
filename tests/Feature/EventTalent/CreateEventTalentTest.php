<?php

namespace Tests\Feature\EventTalent;

use App\Models\Event;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEventTalentTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateEventTalentSuccess(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');

        $event = Event::factory()->create();
        $event_id = $event->id;
        $talent = Talent::factory()->create();
        $talent_ids = [ $talent->id ];

        $requestBody = [
            'event_id'   => $event_id,
            'talent_ids' => $talent_ids,
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('POST', '/api/event-talent', $requestBody);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function testCreateEventTalentFailedEventIdNotFound(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');

        $talent = Talent::factory()->create();
        $talent_ids = [ $talent->id ];

        $requestBody = [
            'event_id'   => 0,
            'talent_ids' => $talent_ids,
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('POST', '/api/event-talent', $requestBody);
        
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }
}
