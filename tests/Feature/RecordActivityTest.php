<?php

namespace Tests\Feature;

use App\Task;
use Tests\Factories\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function creating_a_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);

        $this->assertNull($project->activity->last()->changes);
    }

    /** @test */
    function updating_a_project()
    {
        $project = app(ProjectFactory::class)->create(['title' => 'Original']);

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);

        $changes = [
            'before' => ['title' => 'Original'],
            'after' => ['title' => 'Changed']
        ];

        $this->assertEquals($changes, $project->activity->last()->changes);
    }

    /** @test */
    function creating_a_new_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->assertCount(2, $project->activity);
        $this->assertEquals('task_created', $project->activity->last()->description);
        $this->assertTrue($project->activity->last()->subject->is($project->tasks[0]));
    }

    /** @test */
    function completing_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->signIn($project->owner)->put($project->tasks[0]->path(), [
            'body' => $project->tasks[0]->body,
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('task_completed', $project->activity->last()->description);
        $this->assertTrue($project->activity->last()->subject->is($project->tasks[0]));
    }

    /** @test */
    function incompleting_a_task()
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

        $this->assertCount(4, $project->activity);
        $this->assertEquals('task_uncompleted', $project->activity->last()->description);
        $this->assertTrue($project->activity->last()->subject->is($project->tasks[0]));
    }

    /** @test */
    function deleting_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
        $this->assertEquals('task_deleted', $project->activity->last()->description);
    }
}
