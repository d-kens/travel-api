<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /*
    * Test Cases
        1. login is successful with valid credentials
        2. login returns an error with invalid credentials
    */


    public function test_login_returns_token_with_valid_credentials():void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);

    }

    public function test_login_return_error_with_invalid_credentials():void
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => "nonexisting@gmail.com",
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    }
}
