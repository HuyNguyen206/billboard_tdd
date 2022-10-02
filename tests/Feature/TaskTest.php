<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_project_can_have_tasks()
    {
        $this->signIn();
        $this->withExceptionHandling();
         $project = Project::factory()->create(['user_id' => auth()->id()]);
         $this->post(route('projects.tasks.store', $project->id),
         [
             'body' => 'Task body'
         ]);

         $this->get(route('projects.show', $project->id))
             ->assertSee('Task body');
    }

    public function test_a_task_require_body()
    {
        $this->signIn();
        $project = Project::factory()->create();

        $this->post(route('projects.tasks.store', $project->id),
        Task::factory()->raw(['body' => null]))
        ->assertSessionHasErrors('body');
    }
}
