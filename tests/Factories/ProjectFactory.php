<?php

namespace Tests\Factories;

use App\Project;
use App\Task;
use App\User;

class ProjectFactory
{
    private $tasksCount = 0;

    private $user;

    public function create(): Project
    {
        $project = factory(Project::class)->create([
             'owner_id' => $this->user ? $this->user->id : factory(User::class)->create()->id,
        ]);

        factory(Task::class, $this->tasksCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }

    public function ownedBy(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function withTasks(int $count = 1)
    {
        $this->tasksCount = $count;

        return $this;
    }
}
