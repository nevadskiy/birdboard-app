<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $this->validate($request, [
            'body' => ['required']
        ]);

        $project->addTask($request->get('body'));

        return redirect($project->path());
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        $this->validate($request, [
            'body' => ['required']
        ]);

        $task->update([
            'body' => $request->get('body'),
            'completed' => $request->has('completed'),
        ]);

        return redirect($task->project->path());
    }
}
