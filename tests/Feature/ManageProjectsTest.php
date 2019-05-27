<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    function a_user_can_view_a_project_create_page()
    {
        $this->signIn()
            ->get(route('projects.create'))
            ->assertOk();
    }

    /** @test */
    function guests_cannot_view_a_project_create_page()
    {
        $this->get(route('projects.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function guests_cannot_view_a_project_edit_page()
    {
        $this->get(route('projects.edit', factory(Project::class)->create()))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function a_user_can_create_a_project()
    {
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes for test.'
        ];

        $response = $this->signIn()->post(route('projects.store'), $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    function a_user_can_delete_a_project()
    {
        $project = factory(Project::class)->create();

        $this->signIn($project->owner)
            ->delete($project->path())
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $project = factory(Project::class)->create();

        $user = factory(User::class)->create();

        $project->invite($user);

        $this->signIn($user)
            ->get(route('projects.index'))
            ->assertSee($project->title);
    }

    /** @test */
    function guests_cannot_delete_a_project()
    {
        $project = factory(Project::class)->create();

        $this->delete($project->path())
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('projects', $project->only('id'));
    }

    /** @test */
    function user_cannot_delete_a_project_of_others()
    {
        $project = factory(Project::class)->create();

        $this->signIn()
            ->delete($project->path())
            ->assertForbidden();

        $this->assertDatabaseHas('projects', $project->only('id'));
    }

    /** @test */
    function invited_members_cannot_delete_a_project()
    {
        $project = factory(Project::class)->create();

        $member = factory(User::class)->create();

        $project->invite($member);

        $this->signIn($member)
            ->delete($project->path())
            ->assertForbidden();

        $this->assertDatabaseHas('projects', $project->only('id'));
    }

    /** @test */
    function a_user_can_view_a_project_update_page()
    {
        $project = factory(Project::class)->create();

        $this->signIn($project->owner)
            ->get(route('projects.edit', $project))
            ->assertOk();
    }

    /** @test */
    function a_user_can_update_a_project()
    {
        $project = factory(Project::class)->create();

        $this->signIn($project->owner);

        $changedAttributes = [
            'title' => 'Changed title',
            'description' => 'Changed description',
            'notes' => 'Changed notes',
        ];

        $response = $this->put($project->path(), $changedAttributes);

        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $changedAttributes);
    }

    /** @test */
    function a_user_can_update_a_general_notes()
    {
        $project = factory(Project::class)->create();

        $this->signIn($project->owner)->put($project->path(), [
            'notes' => 'Changed'
        ]);

        $this->assertDatabaseHas('projects', [
            'notes' => 'Changed',
        ]);
    }

    /** @test */
    function a_user_can_view_a_project()
    {
        $project = factory(Project::class)->create([
            'title' => 'Project title',
            'description' => 'Project description',
            'notes' => 'General notes for test.'
        ]);

        $this->signIn($project->owner);

        $this->get($project->path())
            ->assertSee('Project title')
            ->assertSee('Project description')
            ->assertSee('General notes for test.');
    }

    /** @test */
    function guests_cannot_create_projects()
    {
        $this->post(route('projects.store'), factory(Project::class)->raw())
            ->assertRedirect(route('login'));
    }

    /** @test */
    function guests_cannot_view_projects()
    {
        $this->get(route('projects.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function guests_cannot_view_a_single_project()
    {
        $this->get(factory(Project::class)->create()->path())
            ->assertRedirect(route('login'));
    }

    /** @test */
    function a_project_requires_a_title()
    {
        $this->signIn()
            ->post(route('projects.store'), factory(Project::class)->raw(['title' => '']))
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_project_requires_a_description()
    {
        $this->signIn()
            ->post(route('projects.store'), factory(Project::class)->raw(['description' => '']))
            ->assertSessionHasErrors('description');
    }

    /** @test */
    function a_user_can_view_their_project()
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)->create([
            'owner_id' => $user->id
        ]);

        $this->signIn($user)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn()
            ->get(factory(Project::class)->create()->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn()
            ->put(factory(Project::class)->create()->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
