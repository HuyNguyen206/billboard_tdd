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
        self::assertEquals("{$project->user->name} created project", $project->activities()->first()->description_extend);
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
        self::assertEquals("{$project->user->name} updated title of the project", $project->activities()->latest('id')->first()->description_extend);
    }

    public function test_create_new_task_record_project_activity()
    {
        $project = ProjectFactory::withTask(1)->create();
        self::assertCount(1, $project->ownActivities);
        $latestActivities = $project->tasks[0]->ownActivities()->latest('id')->first();
        self::assertEquals("{$project->user->name} created task", $latestActivities->description_extend);
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
        $activity = Activity::latest('id')->first();
        self::assertEquals("$user->name completed task", $activity->description_extend);
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

        $activity = Activity::latest('id')->first();
        self::assertEquals("$user->name uncompleted task", $activity->description_extend);
    }

    public function test_delete_a_task()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->withTask(1, ['body' => 'new'])->create();

        Livewire::test(TaskUpdate::class, ['task' => $task = $project->tasks()->first()])
            ->call('deleteTask');

        self::assertCount(2, $task->ownActivities);
        $activity = Activity::latest('id')->first();
        self::assertEquals("{$activity->user->name} deleted task", $activity->description_extend);
    }
}
