<?php

namespace Tests\Feature\EventTicketCategory;

use App\Models\EventTicketCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByEventIdTest extends TestCase
{
    use RefreshDatabase;

    public function GetEventTicketCategoriesByEventIdSuccess(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');

        $event_ticket_categories = EventTicketCategory::factory()->create();
        $event_ticket_category = $event_ticket_categories->first();
        $event_id = $event_ticket_category->event_id;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', '/api/ticket-category/' . $event_id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }
}
