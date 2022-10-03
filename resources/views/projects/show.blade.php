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

        <a class="px-4 py-2 rounded-full bg-blue-600 text-white" href="{{route('projects.edit', $project->id)}}">Edit
            project</a>
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
                         <textarea placeholder="Add note..." style="min-height: 200px" class="w-full bg-white border-0" name="notes" id="" cols="30"
                                   rows="10">{{$project->notes}}</textarea>
                        <button class="px-4 py-2 rounded-full bg-blue-600 text-white">Save</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="lg:w-1/4">
            <x-card :project="$project" :isLimitHeight="false"></x-card>
        </div>

    </div>
</x-app-layout>
