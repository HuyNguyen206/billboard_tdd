<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
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
            'email' => 'nguyenlehuyuit@gmail.com',
            'name' => 'huy'
        ]);
        $users = (\App\Models\User::factory(10)->create())->push($huy);
//        $projects = Project::factory(5)->create();
        $users->each(function ($user) {
            Project::factory(rand(2, 5))->create(['user_id' => $user->id]);
        });

        Project::all()->each(function ($project) {
           Task::factory(rand(2, 5))->create(['project_id' => $project->id]);

           $project->members()->attach(User::query()->where('id', '!=', $project->user_id)->inRandomOrder()->take(rand(2, 6))->get());
        });

    }
}
