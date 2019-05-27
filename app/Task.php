<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;

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

    public function activityOwner()
    {
        if (auth()->check()) {
            return auth()->user();
        }

        return $this->project->owner;
    }

    protected static function recordableEvents()
    {
        return ['created', 'deleted'];
    }
}
