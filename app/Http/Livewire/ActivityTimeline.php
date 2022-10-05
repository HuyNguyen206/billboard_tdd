<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ActivityTimeline extends Component
{
    public $project;

    protected $listeners = ['changeTask'];

    public function mounted($project)
    {
      $this->project = $project;
    }

    public function render()
    {
        return view('livewire.activity-timeline');
    }

    public function changeTask()
    {
        $this->project->refresh();
    }
}
