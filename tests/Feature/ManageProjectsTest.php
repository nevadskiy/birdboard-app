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
    function a_user_can_create_a_project()
    {
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $response = $this->signIn()->post(route('projects.store'), $attributes);

        $response->assertRedirect(Project::where($attributes)->first()->path());
        $this->assertDatabaseHas('projects', $attributes);
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
}
