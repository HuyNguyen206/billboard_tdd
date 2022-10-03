<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    public $user;
    public $taskCount = 0;
    public $taskData = [];

    public function ownedBy(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function withTask(int $count = 1, array $data = [])
    {
        $this->taskCount = $count;
        $this->taskData = $data;

        return $this;
    }

    public function create(array $data = [])
    {
        $dataCreate = $data + ['user_id' => ($this->user ?? User::factory()->create())->id];
        $project = Project::factory()->create($dataCreate);

        Task::factory($this->taskCount)->create(
            $this->taskData + [
            'project_id' => $project->id
        ]);

        return $project;
    }
}
