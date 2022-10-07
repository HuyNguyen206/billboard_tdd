<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_invite_user()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = User::factory()->create());

        self::assertTrue($project->hasMember($newUser));
    }

    public function test_project_can_invite_user_via_endpoint()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();
        $invitedUser =  User::factory()->create();
        $this->post(route('projects.invite', $project->id), [
            'email' => $invitedUser->email
        ])->assertRedirect(route('projects.show', $project->id));

        self::assertTrue($project->members()->where('user_id', $invitedUser->id)->exists());
    }

    public function test_project_can_only_invite_user_with_exist_email_via_endpoint()
    {
        $user = $this->signIn(User::factory()->create(['email' => 'exist@mail.com']));
        $project = ProjectFactory::ownedBy($user)->create();
        $this->post(route('projects.invite', $project->id), [
            'email' => 'non_exist@mail.com'
        ])->assertSessionHasErrors([
            'email' => 'The invited user must have existing account in Billboard'
        ]);

    }

    public function test_invite_project_required_email_via_endpoint()
    {
        $user = $this->signIn(User::factory()->create(['email' => 'exist@mail.com']));
        $project = ProjectFactory::ownedBy($user)->create();
        $this->post(route('projects.invite', $project->id))
        ->assertSessionHasErrors('email');

    }

   public function test_only_owner_project_can_invite()
    {
        $this->signIn();
        $this->post(route('projects.invite', ProjectFactory::create()->id))
        ->assertStatus(403);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_invited_user_can_add_task()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = User::factory()->create());
        $this->signIn($newUser);
        $this->post(route('projects.tasks.store', $project), $data = Task::factory()->raw(['project_id' => $project->id]));

        $this->assertDatabaseHas('tasks', $data);
    }

}
