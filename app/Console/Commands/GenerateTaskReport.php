<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class GenerateTaskReport extends Command
{
    protected $signature = 'tasks:report {--project_id=}';

    protected $description = 'Generate a report of tasks';

    public function handle(): int
    {
        $projectId = $this->option('project_id');

        $query = Task::query();

        // Фільтрація за ID проєкту
        if ($projectId !== null && $projectId !== '') {
            if (!ctype_digit((string) $projectId) ||
                (int) $projectId < 1) {
                $this->error('Invalid project ID.');
                return self::FAILURE;
            }

            $query->where('project_id', $projectId);
        }

        $tasks = $query->orderBy('id')->get();

        if ($tasks->isEmpty()) {
            $this->warn('No tasks found.');
            return self::SUCCESS;
        }

        $this->info('Tasks found: ' . $tasks->count());

        $rows = $tasks->map(function ($task) {
            return [
                $task->id,
                $task->title,
                $task->status,
                (string) ($task->due_date ?? '-'),
            ];
        })->toArray();

        $this->table(
            ['ID', 'Title', 'Status', 'Due Date'],
            $rows
        );

        return self::SUCCESS;
    }
}
