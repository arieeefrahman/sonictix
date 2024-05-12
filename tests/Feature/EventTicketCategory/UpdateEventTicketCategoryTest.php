<?php

namespace Tests\Feature\EventTicketCategory;

use App\Models\EventTicketCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class UpdateEventTicketCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_event_ticket_category_success(): void
    {
        $user = User::factory()->create();
        
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');

        $event_ticket_categories = EventTicketCategory::factory()->create();
        $id = $event_ticket_categories->id;

        $requestBody = [
            'name' => fake()->name(),
            'price' => rand(1000, 9999),
            'ticket_stock' => rand(0, 100),        
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('PUT', '/api/ticket-category/' . $id, $requestBody);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_update_event_ticket_category_failed_id_not_found(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');

        $id = 0;

        $requestBody = [
            'name' => fake()->name(),
            'price' => rand(1000, 9999),
            'ticket_stock' => rand(0, 100),        
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('PUT', '/api/ticket-category/' . $id, $requestBody);

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function test_update_event_ticket_category_failed_bad_request(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');

        $event_ticket_categories = EventTicketCategory::factory()->create();
        $id = $event_ticket_categories->id;

        $requestBody = [
            'name' => fake()->name(),
            'price' => fake()->name(),
            'ticket_stock' => rand(0, 100),        
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('PUT', '/api/ticket-category/' . $id, $requestBody);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function test_update_event_ticket_category_failed_id_not_numeric(): void
    {
        $user = User::factory()->create();
        
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        $id = 'test';

        $requestBody = [
            'name' => fake()->name(),
            'price' => fake()->name(),
            'ticket_stock' => rand(0, 100),        
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('PUT', '/api/ticket-category/' . $id, $requestBody);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }
}
