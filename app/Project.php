<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function (Project $project) {
            $project->activity()->create([
                'description' => 'created',
            ]);
        });

        static::updated(function (Project $project) {
            $project->activity()->create([
                'description' => 'updated',
            ]);
        });
    }

    protected $guarded = [];

    public function path(): string
    {
        return route('projects.show', $this);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask(string $body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
