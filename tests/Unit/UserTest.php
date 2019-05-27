<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\Factories\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_many_projects()
    {
        $this->assertInstanceOf(Collection::class, factory(User::class)->create()->projects);
    }

    /** @test */
    function it_has_accessible_projects()
    {
        $user = factory(User::class)->create();

        $project = app(ProjectFactory::class)->ownedBy($user)->create();

        $this->assertCount(1, $user->accessibleProjects());
        $this->assertTrue($user->accessibleProjects()->contains($project));

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $anotherProject = app(ProjectFactory::class)->ownedBy($user1)->create();
        $anotherProject->invite($user);

        $this->assertCount(2, $user->accessibleProjects());
        $this->assertTrue($user->accessibleProjects()->contains($anotherProject));

        $this->assertEmpty($user2->accessibleProjects());
    }
}
