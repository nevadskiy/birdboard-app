<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_a_path()
    {
        $task = factory(Task::class)->create();

        $path = route('project.tasks.update', ['task' => $task->id, 'project' => $task->project_id]);

        $this->assertEquals($path, $task->path());
    }

    /** @test */
    function it_belongs_to_a_project()
    {
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    function it_can_be_completed()
    {
        $task = factory(Task::class)->create();

        $this->assertFalse($task->fresh()->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }


    /** @test */
    function it_can_be_uncompleted()
    {
        $task = factory(Task::class)->create(['completed' => true]);

        $this->assertTrue($task->completed);

        $task->uncomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
