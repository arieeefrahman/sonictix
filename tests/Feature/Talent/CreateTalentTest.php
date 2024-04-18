<?php

namespace Tests\Feature\Talent;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTalentTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTalentSuccess(): void
    {
        $user = User::factory()->create();
        
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        
        $token = $loginResponse->json('data.token');
        
        $requestBody = [
            'stage_name' => fake()->name(),
            'real_name' => fake()->name(),
            'image_url' => fake()->url(),
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('POST', '/api/talent', $requestBody);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function testCreateTalentFailed(): void
    {
        $user = User::factory()->create();
        
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        
        $token = $loginResponse->json('data.token');
        
        $requestBody = [];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer' . $token,
        ])->json('POST', '/api/talent', $requestBody);
        
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }
}
