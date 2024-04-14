<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    public function testSuccessLogin()
    {
        $user = User::factory()->create();

        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $credentials);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'token',
                'type',
                'expires_in',
            ],
        ]);
    }

    public function testLoginWithBothUsernameAndEmail()
    {
        $credentials = [
            'username'  => 'testuser',
            'email'     => 'testuser@example.com',
            'password'  => 'password123',
        ];

        $response = $this->post('/api/login', $credentials);
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function testLoginWithUnregisteredUser()
    {
        $credentials = [
            'username' => 'unregistereduser',
            'password' => 'unregistereduser',
        ];

        $response = $this->post('/api/login', $credentials);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function testLoginWithInvalidBodyRequest()
    {
        $credentials = [
            'username' => 'invalidrequest',
            'password' => 123,
        ];

        $response = $this->post('/api/login', $credentials);
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
            'errors' => [
                'password',
            ],
        ]);
    }
}
