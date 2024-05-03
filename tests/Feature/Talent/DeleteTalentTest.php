<?php

namespace Tests\Feature\Talent;

use App\Models\Talent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTalentTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteTalentSuccess(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        $talent = Talent::factory()->create();
        $id = $talent->id;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/talent/' . $id);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function testDeleteTalentByIdNotFound(): void
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
        ])->delete('/api/talent/' . $id);
        
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function testDeleteTalentByNonNumericId(): void
    {
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $loginResponse = $this->post('/api/login', $credentials);
        $token = $loginResponse->json('data.token');
        $id = 'non numeric id';

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/talent/' . $id);
        
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }
}
