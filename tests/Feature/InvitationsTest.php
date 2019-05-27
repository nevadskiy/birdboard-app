<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_project_can_invite_a_user()
    {
        $project = factory(Project::class)->create();

        $anotherUser = factory(User::class)->create();

        $project->invite($anotherUser);

        $attributes = ['body' => 'Test task'];

        $this->signIn($anotherUser)
            ->post(route('project.tasks.store', $project), $attributes);

        $this->assertDatabaseHas('tasks', $attributes);
    }
}
