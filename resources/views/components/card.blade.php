@props([
 'project' => $project,
 'isLimitHeight' => true
])
<div @if($isLimitHeight) style="height: 200px" @endif class="relative p-6 bg-white inline-block rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    <a href="{{route('projects.show', $project->id)}}" class="pl-6 -ml-6 border-l-4 border-l-blue-500 mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $isLimitHeight ? Str::limit($project->title, 30) : $project->title}}</a>
    <p class="font-normal text-gray-700 dark:text-gray-400">{{$isLimitHeight ? Str::limit($project->description) : $project->description}}</p>
    <form action="{{route('projects.destroy', $project->id)}}" method="post">
        @csrf
        @method('delete')
        <button class="text-red-700 absolute right-0 bottom-0 mr-2 mb-2">Delete</button>
    </form>

</div>
