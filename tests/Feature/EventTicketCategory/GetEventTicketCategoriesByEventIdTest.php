<?php

namespace Tests\Feature\EventTicketCategory;

use App\Models\EventTicketCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetEventTicketCategoriesByEventIdTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_event_ticket_categories_by_event_id_success(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');

        $event_ticket_categories = EventTicketCategory::factory()->create();
        $event_id = $event_ticket_categories->event_id;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', '/api/event/'. $event_id . '/ticket-categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function test_get_event_ticket_categories_by_event_id_failed_event_id_not_found(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        $event_id = 0;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', '/api/event/'. $event_id . '/ticket-categories');

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }
}
