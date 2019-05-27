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
    function a_project_owner_can_invite_a_user()
    {
        $project = factory(Project::class)->create();

        $anotherUser = factory(User::class)->create();

        $this->signIn($project->owner)
            ->post(route('project.invitations.store', $project), [
                'email' => $anotherUser->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($anotherUser));
    }

    /** @test */
    function non_owners_may_not_invite_users()
    {
        $project = factory(Project::class)->create();

        $member = factory(User::class)->create();

        $project->invite($member);

        $this->signIn($member)
            ->post(route('project.invitations.store', $project))
            ->assertForbidden();
    }

    /** @test */
    function the_email_address_must_be_an_address_of_existing_user()
    {
        $project = factory(Project::class)->create();

        $this->signIn($project->owner)
            ->post(route('project.invitations.store', $project), [
                'email' => 'invalid@mail.com'
            ])
            ->assertSessionHasErrors(['email' => 'The user you are inviting must have an account'], null, 'invitations');
    }

    /** @test */
    function invited_users_may_update_project_details()
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
