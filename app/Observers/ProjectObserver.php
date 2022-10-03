<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function created(Project $project)
    {
        $this->recordActivities($project, 'created');
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function updated(Project $project)
    {
        $this->recordActivities($project, 'updated');
    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function deleted(Project $project)
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }

    protected function recordActivities(Project $project, $type)
    {
        $project->activities()->create([
            'description' => $type
        ]);
    }
}
