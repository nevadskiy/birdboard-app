<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Tests\Factories\ProjectFactory;
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
        $project = factory(Project::class)->create();

        $this->signIn()
            ->post(route('project.tasks.store', $project), ['body' => 'Test task'])
            ->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    function a_project_can_have_tasks()
    {
        $project = factory(Project::class)->create();

        $this->signIn($project->owner)
            ->post(route('project.tasks.store', $project), ['body' => 'Test task']);

        $this->get($project->path())
            ->assertOk()
            ->assertSee('Test task');
    }

    /** @test */
    function a_task_can_be_updated()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->signIn($project->owner)->put($project->tasks[0]->path(), [
            'body' => 'New body',
        ]);

        $this->assertEquals('New body', $project->tasks[0]->fresh()->body);
    }

    /** @test */
    function a_task_can_be_completed()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->signIn($project->owner)->put($project->tasks[0]->path(), [
            'body' => 'New body',
            'completed' => true,
        ]);

        $this->assertEquals('New body', $project->tasks[0]->fresh()->body);
        $this->assertTrue($project->tasks[0]->fresh()->completed);
    }

    /** @test */
    function a_task_can_be_marked_as_uncompleted()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->signIn($project->owner)->put($project->tasks[0]->path(), [
            'body' => $project->tasks[0]->body,
            'completed' => true,
        ]);

        $this->put($project->tasks[0]->path(), [
            'body' => $project->tasks[0]->body,
            'completed' => false,
        ]);

        $this->assertFalse($project->tasks[0]->fresh()->completed);
    }

    /** @test */
    function only_owners_of_a_project_may_update_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $response = $this->signIn()->put($project->tasks[0]->path(), [
            'body' => 'Test task updated'
        ]);

        $response->assertForbidden();
        $this->assertNotEquals('Test task', $project->tasks[0]->fresh()->body);
    }

    /** @test */
    function a_task_requires_a_body()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post(route('project.tasks.store', $project), factory(Task::class)->raw(['body' => '']))
            ->assertSessionHasErrors('body');
    }
}
