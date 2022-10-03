<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::factory(10)->create();
//        $projects = Project::factory(5)->create();
        $users->each(function ($user) {
            $user->projects()->createMany(Project::factory(rand(2, 5))->raw());
        });

        Project::all()->each(function ($project) {
            $project->tasks()->createMany(Task::factory(rand(2, 5))->raw());
        });
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
