<?php

namespace Tests\Feature\EventTicketCategory;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEventTicketCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateEventTicketCategorySuccessTwoItems(): void
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
        $requestBody = [
            [
                'event_id' => $event_id,
                'name' => fake()->name(),
                'price' => rand(1000, 9999),
                'ticket_stock' => rand(0, 100),
            ],
            [
                'event_id' => $event_id,
                'name' => fake()->name(),
                'price' => rand(1000, 9999),
                'ticket_stock' => rand(0, 100),
            ]
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('POST', '/api/ticket-category', $requestBody);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function testCreateEventTicketCategorySuccessOneItem(): void
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

        $requestBody = [
            [
            'event_id' => $event_id,
            'name' => fake()->name(),
            'price' => rand(1000, 9999),
            'ticket_stock' => rand(0, 100),
            ]
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('POST', '/api/ticket-category', $requestBody);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function testCreateEventTicketCategoryFailedBadRequest(): void
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

        $requestBody = [
            [
            'event_id' => $event_id,
            'price' => rand(1000, 9999),
            'ticket_stock' => rand(0, 100),
            ]
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('POST', '/api/ticket-category', $requestBody);
        
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
            'errors'
        ]);
    }
}
