<?php

namespace Tests\Feature;

use Tests\Factories\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function creating_a_project_records_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test */
    function updating_a_project_records_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    function creating_a_new_task_records_activity_for_the_project()
    {
        $project = app(ProjectFactory::class)->create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('task_created', $project->activity->last()->description);
    }

    /** @test */
    function completing_a_task_records_activity_for_the_project()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->signIn($project->owner)->put($project->tasks[0]->path(), [
            'body' => $project->tasks[0]->body,
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('task_completed', $project->activity->last()->description);
    }
}
