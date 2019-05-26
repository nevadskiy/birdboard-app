<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $casts = [
        'completed' => 'bool'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function (Task $task) {
            $task->project->recordActivity('task_created');
        });

        static::updated(function (Task $task) {
            if (! $task->completed) {
                return;
            }

            $task->project->recordActivity('task_completed');
        });
    }

    protected $touches = [
        'project',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return route('project.tasks.update', [
            'task' => $this->id, 'project' => $this->project_id
        ]);
    }

    public function complete()
    {
        return $this->update(['completed' => true]);
    }

    public function incomplete()
    {
        return $this->update(['completed' => false]);
    }
}
