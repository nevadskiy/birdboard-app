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
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post(route('project.tasks.store', $project), ['body' => 'Test task']);

        $this->get($project->path())
            ->assertOk()
            ->assertSee('Test task');
    }

    /** @test */
    function a_task_can_be_updated()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $task = $project->addTask('Test task');

        $this->put($task->path(), [
            'body' => 'New body',
            'completed' => true,
        ]);

        $this->assertEquals('New body', $task->fresh()->body);
        $this->assertTrue($task->fresh()->completed);
    }

    /** @test */
    function only_owners_of_a_project_may_update_a_task()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $task = $project->addTask('Test task');

        $response = $this->put($task->path(), [
            'body' => 'Test task updated'
        ]);

        $response->assertForbidden();
        $this->assertEquals('Test task', $task->fresh()->body);
    }

    /** @test */
    function a_task_requires_a_body()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post(route('project.tasks.store', $project), $attributes)
            ->assertSessionHasErrors('body');
    }
}
