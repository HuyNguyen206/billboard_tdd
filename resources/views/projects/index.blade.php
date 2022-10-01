<x-app-layout>
    <div>
        <div class="flex justify-between items-center my-4">
            <h1 class="font-bold text-2xl">Billboard</h1>
            <a class="px-4 py-2 rounded-full bg-blue-600 text-white" href="{{route('projects.create')}}">Create a new project</a>
        </div>
        <div class="flex flex-wrap">
            @foreach($projects as $project)
                <div class="w-1/3 px-2 py-2">
                    <div href="{{route('projects.show', $project->id)}}" style="height: 200px" class="p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{Str::limit($project->title, 30)}}</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">{{Str::limit($project->description)}}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
