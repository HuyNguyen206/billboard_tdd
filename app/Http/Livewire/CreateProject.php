<?php

namespace App\Http\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateProject extends Component
{
    public $tasks = [];
    public $title;
    public $description;
    public $show = false;

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'tasks' => ''
    ];

    public function render()
    {
        return view('livewire.create-project');
    }

    public function createProject()
    {
        dd($this->tasks);
        $validatedData = $this->validate();

        $project = DB::transaction(function () use($validatedData){
            $project = auth()->user()->projects()->create(Arr::except($validatedData, ['tasks']));
            dd($this->tasks, $validatedData);
            if($this->tasks) {
                $project->tasks()->createMany($validatedData['tasks']);
            }

            return $project;
        });

        $this->redirect(route('projects.show', $project->id));

        $this->dispatchBrowserEvent('project-created');
    }
}
