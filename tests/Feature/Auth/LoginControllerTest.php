<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function testRequireEmailAndLogin()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The email field is required. (and 1 more error)',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    public function testUserLoginSuccessfully()
    {
        $user = ['email' => 'user@email.com', 'password' => 'userpass'];
        $this->json('POST', 'api/auth/login', $user)
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'user' => [
                    'id',
                    'name',
                    'email',
                ]
            ]);
    }
    public function testLogoutSuccessfully()
    {
        $user = [
            'email' => 'user@email.com',
            'password' => 'userpass'
        ];
        $token = $this->json('POST', 'api/auth/login', $user)->json()['access_token'];
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('POST', 'api/auth/logout', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out'
            ]);
    }
}
