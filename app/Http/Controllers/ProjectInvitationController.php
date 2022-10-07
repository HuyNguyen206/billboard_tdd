<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectInvitationController extends Controller
{
    public function invite(Project $project, ProjectInvitationRequest $request)
    {
        $project->invite(User::where('email', $request->email)->first());

        return redirect()->route('projects.show', $project->id);
    }
}
