<?php

namespace Tests\Feature;

use App\Http\Livewire\TaskUpdate;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();
         $this->post(route('projects.tasks.store', $project->id),
         [
             'body' => 'Task body'
         ]);

         $this->get(route('projects.show', $project->id))
             ->assertSee('Task body');
    }

    public function test_a_task_require_body()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();

        $this->post(route('projects.tasks.store', $project->id),
        Task::factory()->raw(['body' => null]))
        ->assertSessionHasErrors('body');
    }

    public function test_a_task_can_be_updated()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->withTask(1, ['body' => 'new'])->create();

        Livewire::test(TaskUpdate::class, ['task' => $project->tasks()->first()])
            ->set('body', 'new update')
            ->set('completed', true)
            ->call('updateTask')
            ->assertStatus(200);

        $this->assertDatabaseHas('tasks', ['body' => 'new update', 'completed' => true]);

    }

    public function test_only_a_owner_of_project_can_add_task()
    {
        $project = ProjectFactory::create();
        $this->signIn();
        $this->post(route('projects.tasks.store', $project->id), [
            'body' => 'new task'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'new task']);
    }

    public function test_only_a_owner_of_project_can_update_task()
    {
        $project = ProjectFactory::withTask(1, ['body' => 'new'])->create();
        $this->signIn();
        Livewire::test(TaskUpdate::class, ['task' => $project->tasks()->first()])
            ->set('body', 'new update')
            ->set('completed', true)
            ->call('updateTask')
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'new update']);
    }
}
