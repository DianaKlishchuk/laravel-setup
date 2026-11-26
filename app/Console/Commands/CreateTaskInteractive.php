<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Events\TaskCreated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateTaskInteractive extends Command
{
    protected $signature = 'tasks:create-interactive';

    protected $description = 'Create a task interactively';

    public function handle(): int
    {
        $this->info('Interactive Task Creation');

        $title = $this->ask('Task title');

        $description = $this->ask('Task description');

        $projectId = $this->ask('Project ID');

        $authorId = $this->ask('Author ID');

        $dueDate = $this->ask(
            'Due date (YYYY-MM-DD, leave empty to skip)'
        );

        $assignedTo = $this->ask(
            'Assignee user ID (leave empty to skip)'
        );

        $status = $this->choice(
            'Task status',
            ['new', 'in_progress', 'done'],
            'new'
        );

        $data = [
            'title' => $title,
            'description' => $description,
            'project_id' => $projectId,
            'author_id' => $authorId,
            'due_date' => $dueDate ?: null,
            'assigned_to' => $assignedTo ?: null,
            'status' => $status,
        ];

        // Перевірка введених даних
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|integer|exists:projects,id',
            'author_id' => 'required|integer|exists:users,id',
            'due_date' => 'nullable|date_format:Y-m-d|after_or_equal:today',
            'assigned_to' => 'nullable|integer|exists:users,id',
            'status' => 'required|in:new,in_progress,done',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        if (!$this->confirm('Save this task?', true)) {
            $this->warn('Task creation cancelled.');

            return self::SUCCESS;
        }

        $task = Task::create($validator->validated());

        TaskCreated::dispatch($task);

        $this->info(
            'Task created successfully! ID: ' . $task->id
        );

        return self::SUCCESS;
    }
}
