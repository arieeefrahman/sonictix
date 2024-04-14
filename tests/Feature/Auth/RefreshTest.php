<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RefreshTest extends TestCase
{
    use RefreshDatabase;

    public function testRefreshSuccess(): void
    {
        $user = User::factory()->create();

        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/refresh');
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'token',
                'type',
                ]
            ]
        );
    }

    public function testRefreshFailed(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . 'invalidtoken',
        ])->post('/api/refresh');
    
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message',
        ]);
    }
}
