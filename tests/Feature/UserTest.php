<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    public function test_guest_user_can_get_all_users(): void
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
    }

    public function test_guest_user_can_create_account(): void
    {
        $userData = User::factory()->make()->toArray();

        $userData['password'] = "legoninjago";

        $response = $this->post('/api/register', $userData, ['Accept' => 'application/json']);


        $response->assertStatus(201);
    }

    public function test_guest_user_can_logg_in(): void
    {
        $password = "password123";
        $user = User::factory()->create([
            'password' => $password,
        ]);

        $loginData = [
            'email'=> $user->email,
            'password'=> $password,
        ];

        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(200);
    }

    public function test_user_can_loggout(): void
    {
        $password = "password123";
        $user = User::factory()->create([
            'password' => $password,
        ]);

        $loginResponse = $this->post('/api/login', [
            'email'=> $user->email,
            'password'=> $password,
        ]);

        $token = $loginResponse->json('token');

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post('/api/logout', [
            'email'=>$user->email,
            'password'=> $password,
        ]);

        $response->assertStatus(200);

    }

    public function test_guest_user_cannot_loggout(): void
    {
        $response = $this->post('/api/logout', [], ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }

}
