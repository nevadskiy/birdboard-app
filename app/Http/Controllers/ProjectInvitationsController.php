<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Project;
use App\User;

class ProjectInvitationsController extends Controller
{
    public function store(ProjectInvitationRequest $request, Project $project)
    {
        $project->invite(
            User::whereEmail($request->get('email'))->first()
        );

        return redirect($project->path());
    }
}
