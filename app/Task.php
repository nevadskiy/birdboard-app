<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $casts = [
        'completed' => 'bool'
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
}
