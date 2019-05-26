<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{
    public function created(Task $task)
    {
        $task->project->recordActivity('task_created');
    }

    public function deleted(Task $task)
    {
        $task->project->recordActivity('task_deleted');
    }
}
