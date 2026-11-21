<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Events\TaskCreated;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::query();

        if ($request->query('include') === 'comments') {
            $tasks->with('comments');
        }

        if ($request->query('include') === 'project') {
            $tasks->with('project');
        }

        $tasks = $tasks->paginate(10);

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        TaskCreated::dispatch($task);

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Task $task)
    {
        if ($request->query('include') === 'comments') {
            $task->load('comments');
        }

        if ($request->query('include') === 'project') {
            $task->load('project');
        }

        return new TaskResource($task);
    }

    public function update(
        UpdateTaskRequest $request,
        Task $task
    ) {
        $task->update($request->validated());

        return new TaskResource($task->refresh());
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
