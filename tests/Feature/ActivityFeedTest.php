<?php

namespace Tests\Feature;

use App\Http\Livewire\TaskUpdate;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_project_generate_activities()
    {
        $project = Project::factory()->create();
        self::assertCount(1, $project->activities);
        self::assertEquals('created', $project->activities()->first()->description);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_project_generate_activities()
    {
        $project = Project::factory()->create();
        $project->update([
           'title' => 'updated'
        ]);
        self::assertCount(2, $project->activities);
        self::assertEquals('updated', $project->activities()->latest('id')->first()->description);
    }

    public function test_create_new_task_record_project_activity()
    {
        $project = ProjectFactory::withTask(1)->create();
        self::assertCount(2, $project->activities);
        self::assertEquals('created task', $project->activities()->latest('id')->first()->description);
    }

    public function test_complete_task_records_project_activity()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->withTask(1, ['body' => 'new'])->create();

        Livewire::test(TaskUpdate::class, ['task' => $project->tasks()->first()])
            ->set('body', 'new update')
            ->set('completed', true)
            ->call('updateTask');

        self::assertCount(3, $project->activities);
        $data = $project->activities()->get('description')->pluck('description')->toArray();
        self::assertContains('created', $data);
        self::assertContains('created task', $data);
        self::assertContains('completed task', $data);
    }
}
