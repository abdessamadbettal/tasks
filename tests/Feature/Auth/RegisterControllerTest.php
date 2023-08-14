<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    public function testRegisterSuccessfully()
    {
        $register = [
            'name' => 'UserTest',
            'email' => 'user@test.com',
            'password' => 'testpass',
            'password_confirmation' => 'testpass'
        ];

        $this->json('POST', 'api/auth/register', $register, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                ]
            ]);
        }

        public function testRequireNameEmailAndPassword()
        {
            $this->json('POST', 'api/auth/register')
                ->assertStatus(422)
                ->assertJson([
                    'message' => 'The name field is required. (and 2 more errors)',
                    'errors' => [
                        'name' => ['The name field is required.'],
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.'],
                    ]
                ]);
        }

        

}
