<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_has_project()
    {
        $user = User::factory()->create();
        $user->projects()->create(Project::factory()->raw());

        $this->assertCount(1, $user->projects);
    }
}
