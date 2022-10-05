<?php

namespace App\Traits;

use App\Models\Activity;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait RecordActivity
{
    public static function bootRecordActivity()
    {
        $recordableEvents = ['deleted', 'created', 'updated'];

        foreach ($recordableEvents as $event) {
            static::$event(function (Model $subject) use($event){
                $subjectName = Str::lower(class_basename($subject));
                if ($event === 'updated') {
                    $description = $subject->getDescription($subjectName, $subject);
                    $subject->recordActivities($description);
                } else {
                    $subject->recordActivities("$event $subjectName");
                }
            });
        }
    }
    /**
     * @return array
     */
    public function activityChanges(): array
    {
        $after = Arr::except($this->getChanges(), 'updated_at');
        $before =  Arr::except(array_intersect_key($this->getOriginal(), $after), 'updated_at');

        return array($after, $before);
    }

    public function recordActivities($description)
    {
        $isProjectActivity = class_basename($this) === 'Project';
        $data = [
                'project_id' => $isProjectActivity ? $this->id : $this->project_id,
            ] + compact('description');

        if ($this->wasChanged()) {
            [$after, $before] = $this->activityChanges();
            $data += ['changes' => compact('before', 'after')];
        }

        $this->ownActivities()->create($data);
    }

    public function ownActivities()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * @param string $subjectName
     * @param Model $subject
     * @return string
     */
    function getDescription(string $subjectName, Model $subject): string
    {
        if ($subjectName === 'task') {
            $isCompleteUpdate = $subject->isDirty('completed');
            $description = $isCompleteUpdate ?
                ($subject->completed ? 'completed task' : 'uncompleted task')
                : 'updated task';
        } else {
            $description = "updated $subjectName";
        }
        return $description;
    }
}
