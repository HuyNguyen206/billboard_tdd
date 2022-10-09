<?php

namespace App\Http\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateProject extends Component
{
    public $tasks = [['body' => '']];
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

    public function initModel()
    {
        $this->reset();
        $this->show = true;
    }

    public function createProject()
    {
        $hasTask = collect(Arr::flatten($this->tasks))->filter()->count();
        $validatedData = $this->validate();

        $project = DB::transaction(function () use($validatedData, $hasTask){
            $project = auth()->user()->projects()->create(Arr::except($validatedData, ['tasks']));

            if($hasTask) {
                $project->tasks()->createMany($validatedData['tasks']);
            }

            return $project;
        });

        $this->redirect(route('projects.show', $project->id));

        $this->dispatchBrowserEvent('project-created');
    }
}
