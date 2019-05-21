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
        $this->actingAs(factory(User::class)->create())
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
    function a_user_can_create_a_project()
    {
        $this->actingAs(factory(User::class)->create());

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $this->post(route('projects.store'), $attributes)->assertRedirect('projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get(route('projects.index'))->assertSee($attributes['title']);
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
        $this->get( factory(Project::class)->create()->path())
            ->assertRedirect(route('login'));
    }

    /** @test */
    function a_project_requires_a_title()
    {
        $this->actingAs(factory(User::class)->create())
            ->post(route('projects.store'), factory(Project::class)->raw(['title' => '']))
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_project_requires_a_description()
    {
        $this->actingAs(factory(User::class)->create())
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

        $this->actingAs($user)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(factory(Project::class)->create()->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
