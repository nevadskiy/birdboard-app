<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function touch(User $user, Project $project)
    {
        return $user->is($project->owner) || $project->members->contains($user);
    }

    public function own(User $user, Project $project)
    {
        return $user->is($project->owner);
    }
}
