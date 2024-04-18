<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSuccess(): void
    {
        $responseBody = [
            'username' => fake()->unique()->userName(),
            'password' => Hash::make('password'),
            'email' => fake()->unique()->safeEmail(),
            'full_name' => fake()->name(),
        ];

        $response = $this->post('/api/register', $responseBody);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function testRegisterFailedUsernameAlreadyRegistered(): void
    {
        $user = User::factory()->create();

        $responseBody = [
            'username' => $user->username,
            'password' => Hash::make('password'),
            'email' => fake()->unique()->safeEmail(),
            'full_name' => fake()->name(),
        ];

        $response = $this->post('/api/register', $responseBody);
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
            'errors',
        ]);
    }

    public function testRegisterFailedRequestBodyIsNotComplete(): void
    {
        $responseBody = [
            'username' => fake()->unique()->userName(),
            'password' => Hash::make('password'),
        ];

        $response = $this->post('/api/register', $responseBody);
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
            'errors',
        ]);
    }
}
