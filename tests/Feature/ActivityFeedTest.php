<?php

namespace Tests\Feature;

use App\Http\Livewire\TaskUpdate;
use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
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
        self::assertEquals('created project', $project->activities()->first()->description);
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
        self::assertEquals('updated project', $project->activities()->latest('id')->first()->description);
    }

    public function test_create_new_task_record_project_activity()
    {
        $project = ProjectFactory::withTask(1)->create();
        self::assertCount(1, $project->ownActivities);
        $latestActivities = $project->tasks[0]->ownActivities()->latest('id')->first();
        self::assertEquals('created task', $latestActivities->description);
        self::assertInstanceOf(Task::class, $latestActivities->subject);
    }

    public function test_complete_task_records_project_activity()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->withTask(1, ['body' => 'new'])->create();
        $latestActivities = Activity::latest('id')->first();
        self::assertCount(1, $project->ownActivities);
        self::assertEquals('new', $latestActivities->subject->body);
        self::assertInstanceOf(Task::class, $latestActivities->subject);

        Livewire::test(TaskUpdate::class, ['task' => $task = $project->tasks()->first()])
            ->set('body', 'new update')
            ->set('completed', true)
            ->call('updateTask');

        self::assertCount(2, $task->ownActivities);
        $data = Activity::get('description')->pluck('description')->toArray();
        self::assertContains('created task', $data);
        self::assertContains('completed task', $data);
    }

    public function test_in_complete_task_records_project_activity()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->withTask(1, ['body' => 'new'])->create();
        Livewire::test(TaskUpdate::class, ['task' => $project->tasks()->first()])
            ->set('body', 'new update')
            ->set('completed', true)
            ->call('updateTask');

        Livewire::test(TaskUpdate::class, ['task' => $project->tasks()->first()])
            ->set('completed', false)
            ->call('updateTask');

        self::assertCount(1, $project->ownActivities);

        $data = Activity::get('description')->pluck('description')->toArray();

        self::assertContains('created project', $data);
        self::assertContains('created task', $data);
        self::assertContains('completed task', $data);
        self::assertContains('uncompleted task', $data);
    }

    public function test_delete_a_task()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->withTask(1, ['body' => 'new'])->create();

        Livewire::test(TaskUpdate::class, ['task' => $task = $project->tasks()->first()])
            ->call('deleteTask');

        self::assertCount(2, $task->ownActivities);
        $data = Activity::get('description')->pluck('description')->toArray();
        self::assertContains('deleted task', $data);
    }
}
