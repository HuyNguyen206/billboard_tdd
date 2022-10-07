<x-app-layout>
    <div class="flex justify-between items-center my-4">
        <div class="flex justify-items-start items-center space-x-2">
            <p class="font-bold text-xl text-gray-400
font-bold text-xl text-gray-400
font-bold text-xl text-gray-400">
                <a href="{{route('projects.index')}}" class="">My projects</a>
                <span class="">/</span>
                <span class="">{{$project->title}}</span>
            </p>
            <a class="px-4 py-2 rounded-full bg-blue-600 text-white" href="{{route('projects.create')}}">Add task</a>
        </div>
        <div class="flex">
            @foreach($project->members as $member)
                <img width="40" class="rounded-full mr-2" src="{{$member->avatar()}}"/>
            @endforeach
            <a class="px-4 py-2 rounded-full bg-blue-600 text-white" href="{{route('projects.edit', $project->id)}}">Edit
                project</a>
        </div>

    </div>
    <div class="lg:flex">
        <div class="lg:w-3/4 mb-2 lg:mb-0 mr-2">
            <div>
                <div class="mb-4">
                    <h2 class="font-bold text-xl text-gray-400">Tasks</h2>
                    @foreach($project->tasks as $task)
                        <livewire:task-update :task="$task"/>
                    @endforeach
                    <form method="post" action="{{route('projects.tasks.store', $project->id)}}">
                        @csrf
                        <input type="text" placeholder="Add new task..." class="w-full border-none " name="body">
                    </form>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-400">General notes</h2>
                    <form action="{{route('projects.update', $project->id)}}" method="post">
                        @method('patch')
                        @csrf
                        <textarea placeholder="Add note..." style="min-height: 200px" class="w-full bg-white border-0"
                                  name="notes" id="" cols="30"
                                  rows="10">{{$project->notes}}</textarea>
                        @error('notes')
                        <p id="standard_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{$message}}
                        </p>
                        @enderror
                        <button class="px-4 py-2 rounded-full bg-blue-600 text-white">Save</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="lg:w-1/4">
            <x-card :project="$project" :isLimitHeight="false"></x-card>
            <livewire:activity-timeline :project="$project"/>
            @can('invite', $project)
                <x-invite-user/>
            @endcan
            {{--            <ul class="w-48 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">--}}
            {{--                @foreach($project->activities as $activity)--}}
            {{--                    <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">{{$activity->description}}</li>--}}
            {{--                @endforeach--}}
            {{--            </ul>--}}
        </div>

    </div>
</x-app-layout>
