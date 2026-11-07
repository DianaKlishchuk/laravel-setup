<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()->count(3)->create();

        foreach ($users as $user) {

            $projects = Project::factory()
                ->count(2)
                ->for($user)
                ->create();

            foreach ($projects as $project) {

                for ($i = 0; $i < 5; $i++) {

                    $status = [
                        'new',
                        'in_progress',
                        'done'
                    ][$i % 3];

                    $task = Task::factory()->create([
                        'project_id' => $project->id,
                        'author_id' => $user->id,
                        'assigned_to' => $users
                            ->random()
                            ->id,
                        'status' => $status,
                    ]);
                    $commentCount = rand(2, 3);

                    $commentUsers = $users
                        ->shuffle()
                        ->take($commentCount);

                    foreach ($commentUsers as $commentUser) {
                        Comment::factory()->create([
                            'task_id' => $task->id,
                            'user_id' => $commentUser->id,
                        ]);
                    }
                }
            }
        }
    }
}
