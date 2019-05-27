<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_a_path()
    {
        $project = factory(Project::class)->create();

        $this->assertEquals(route('projects.show', $project), $project->path());
    }

    /** @test */
    function it_belongs_to_an_owner()
    {
        $this->assertInstanceOf(User::class, factory(Project::class)->create()->owner);
    }

    /** @test */
    function it_can_add_a_task()
    {
        $project = factory(Project::class)->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
        $this->assertEquals('Test task', $task->body);
    }

    /** @test */
    function it_has_many_projects()
    {
        $this->assertInstanceOf(Collection::class, factory(Project::class)->create()->tasks);
    }

    /** @test */
    function it_invites_a_user()
    {
        $project = factory(Project::class)->create();

        $user = factory(User::class)->create();

        $project->invite($user);

        $this->assertTrue($project->members->contains($user));
    }
}
