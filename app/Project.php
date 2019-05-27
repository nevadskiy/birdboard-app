<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;

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
        return $this->hasMany(Activity::class)->latest();
    }

    public function activityOwner()
    {
        if (auth()->check()) {
            return auth()->user();
        }

        return $this->owner;
    }

    protected static function recordableEvents()
    {
        return ['created', 'updated'];
    }

    protected function activityDescription($description)
    {
        return $description;
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->withTimestamps();
    }
}
