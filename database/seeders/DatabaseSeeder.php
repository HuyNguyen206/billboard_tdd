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
        $huy = \App\Models\User::factory()->create([
            'email' => 'nguyenlehuyuit@gmail.com'
        ]);
        $users = (\App\Models\User::factory(10)->create())->push($huy);
//        $projects = Project::factory(5)->create();
        $users->each(function ($user) {
            Project::factory(rand(2, 5))->create(['user_id' => $user->id]);
        });

        Project::all()->each(function ($project) {
           Task::factory(rand(2, 5))->create(['project_id' => $project->id]);
        });
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
