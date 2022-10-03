<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $touches = ['project'];

    protected static function booted()
    {
        static::created(function (Task $task){
            Activity::create([
                'description' => 'created task',
                'project_id' => $task->project_id
            ]);
        });

        static::updated(function (Task $task){
            if (!$task->isDirty('completed')) {
              return;
            }

            Activity::create([
                'description' => $task->completed ? 'completed task' : 'uncompleted task',
                'project_id' => $task->project_id
            ]);
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
