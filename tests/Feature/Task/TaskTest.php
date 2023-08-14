<?php

namespace Tests\Feature\Task;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class TaskTest extends TestCase
{
    public $headers;
    public $taskId ;


    public function testShouldNotCreateTaskWithoutAccessToken()
    {
        $task = [
            'title' => 'Task title',
            'description' => 'Task description',
        ];

        $response = $this->json('POST', 'api/tasks', $task);
        $response->assertStatus(401);
    }





    public function testShouldCreateTask()
    {
        // add access token
        $user = [
            'email' => 'user@email.com',
            'password' => 'userpass'
        ];
        $token = $this->json('POST', 'api/auth/login', $user)->json()['access_token'];
        $this->headers = ['Authorization' => "Bearer $token"];

        // create task
        $task = [
            'title' => 'Task title',
            'description' => 'Task description',
        ];

        $response = $this->json('POST', 'api/tasks', $task, $this->headers);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);
        $this->taskId = $response->json()['data']['id'];


    }

    public function testShouldNotCreateTaskWithoutTitle()
    {
        $task = [
            'description' => 'Task description',
        ];

        $response = $this->json('POST', 'api/tasks', $task, $this->headers);
        $response->assertStatus(422);
    }

    public function testShouldNotCreateTaskWithoutDescription()
    {
        $task = [
            'title' => 'Task title',
        ];

        $response = $this->json('POST', 'api/tasks', $task, $this->headers);
        $response->assertStatus(422);
    }

    public function testShouldGetAllTasks()
    {
        $response = $this->json('GET', 'api/tasks', [], $this->headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'status',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    public function testShouldUpdateTask()
    {
        $task = [
            'status' => 'done',
        ];

        $response = $this->json('PUT', 'api/tasks/' . $this->taskId, $task, $this->headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function testShouldNotUpdateTaskWithoutTitle()
    {
        $task = [
            'title' => '',
        ];

        $response = $this->json('PUT', 'api/tasks/' . $this->taskId, $task, $this->headers);
        $response->assertStatus(422);
    }

    public function testDeleteTask()
    {
        $response = $this->json('DELETE', 'api/tasks/' . $this->taskId, [], $this->headers);
        $response->assertStatus(204);
    }


}
