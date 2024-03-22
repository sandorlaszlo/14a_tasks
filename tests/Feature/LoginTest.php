<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_login_route_get_not_exists(): void
    {
        $response = $this->get('/api/login');

        $response->assertStatus(405);
    }

    public function test_valid_user_can_login_and_get_token(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);;

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
        $response->assertJson(['user' => ['id' => $user->id]]);
    }

    public function test_invalid_user_login_fails(): void{
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistinguser@user.com',
            'password' => 'password',
        ]);;

        $response->assertStatus(401);

    }
}
