<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Support\Facades\Log;

class NotifyAssignee
{
    public function handle(TaskCreated $event): void
    {
        $task = $event->task;

        if ($task->assigned_to !== null) {
            Log::info('Task assigned to user', [
                'task_id' => $task->id,
                'title' => $task->title,
                'assigned_to' => $task->assigned_to,
            ]);
        }
    }
}
