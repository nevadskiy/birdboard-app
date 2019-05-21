<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

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
        $attributes = factory(Project::class)->raw();

        $this->post(route('projects.store'), $attributes)
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
        $project = factory(Project::class)->create();

        $this->get($project->path())
            ->assertRedirect(route('login'));
    }

    /** @test */
    function a_project_requires_a_title()
    {
        $this->actingAs(factory(User::class)->create());

        $attributes = factory(Project::class)->raw(['title' => '']);

        $this->post(route('projects.store'), $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    function a_project_requires_a_description()
    {
        $this->actingAs(factory(User::class)->create());

        $attributes = factory(Project::class)->raw(['description' => '']);

        $this->post(route('projects.store'), $attributes)->assertSessionHasErrors('description');
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
