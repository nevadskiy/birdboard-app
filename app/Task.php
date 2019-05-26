<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $casts = [
        'completed' => 'bool'
    ];

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
        $this->update(['completed' => true]);

        $this->recordActivity('task_completed');
    }

    public function uncomplete()
    {
        $this->update(['completed' => false]);

        $this->recordActivity('task_uncompleted');
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity(string $description)
    {
        return $this->activity()->create([
            'user_id' => $this->activityOwner()->id,
            'project_id' => $this->project_id,
            'description' => $description,
        ]);
    }

    public function activityOwner()
    {
        if (auth()->check()) {
            return auth()->user();
        }

        return $this->project->owner;
    }
}
