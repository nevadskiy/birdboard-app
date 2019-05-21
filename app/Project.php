<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path(): string
    {
        return route('projects.show', $this);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}