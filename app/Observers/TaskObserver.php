<?php

namespace App\Observers;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    public function created(Task $task): void
    {
        Log::info('Task created', [
            'task_id' => $task->id,
            'title' => $task->title,
        ]);
    }

    public function updated(Task $task): void
    {
        if ($task->wasChanged('status')) {
            Log::info('Task status changed', [
                'task_id' => $task->id,
                'title' => $task->title,
                'old_status' => $task->getOriginal('status'),
                'new_status' => $task->status,
            ]);
        }
    }

    public function deleted(Task $task): void
    {
        Log::info('Task deleted', [
            'task_id' => $task->id,
            'title' => $task->title,
        ]);
    }
}
