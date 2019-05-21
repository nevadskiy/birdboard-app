<?php

namespace Tests\Unit;

use App\Project;
use App\User;
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
}
