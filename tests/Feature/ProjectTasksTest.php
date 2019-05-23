<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_add_tasks_to_projects()
    {
        $this->post(route('project.tasks.store', factory(Project::class)->create()))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function only_owners_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->post(route('project.tasks.store', $project), ['body' => 'Test task'])
            ->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    function a_project_can_have_tasks()
    {
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->signIn()->post(route('project.tasks.store', $project), ['body' => 'Test task']);

        $this->get($project->path())
            ->assertOk()
            ->assertSee('Test task');
    }

    /** @test */
    function a_task_requires_a_body()
    {
        $project = factory(Project::class)->create();

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->signIn()->post(route('project.tasks.store', $project), $attributes)
            ->assertSessionHasErrors('body');
    }
}
