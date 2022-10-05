<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class TaskUpdate extends Component
{
    use AuthorizesRequests;

    public $body;
    public $completed;
    public $task;

    protected $rules = [
        'body' => 'required'
    ];

    public function mount($task)
    {
        $this->task = $task;
        $this->body = $task->body;
        $this->completed = $task->completed;
    }

    public function render()
    {
        return view('livewire.task-update');
    }

    public function updateTask()
    {
        $project = $this->task->project;
        $this->authorize('update', $project);

        $this->validate();

        $this->task->update(['body' => $this->body, 'completed' => $this->completed]);

//        if ($this->completed) {
//            $this->task->complete();
//        } else {
//            $this->task->incomplete();
//        }

        $this->emitTo(ActivityTimeline::class, 'changeTask');
    }

    public function deleteTask()
    {
        $project = $this->task->project;
        $this->authorize('delete', $project);

        $this->task->delete();
        $this->emitTo(ActivityTimeline::class, 'changeTask');
    }
}
