<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = auth()->user()->tasks()->orderBy('updated_at', 'desc')->get();
        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {

            $task = auth()->user()->tasks()->create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'todo',
            ]);

            return new TaskResource($task);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {

            if(auth()->user()->id !== $task->user_id){
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return new TaskResource($task);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {

                if(auth()->user()->id !== $task->user_id){
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                $task->update([
                    'status' => $request->status,
                    'updated_at' => now(),
                ]);


                return new TaskResource($task);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {

                if(auth()->user()->id !== $task->user_id){
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                $task->delete();

                return response()->json(null, 204);
    }
}
