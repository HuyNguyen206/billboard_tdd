@props([
 'project' => $project,
 'isLimitHeight' => true
])
<a href="{{route('projects.show', $project->id)}}" @if($isLimitHeight) style="height: 200px" @endif class="p-6 bg-white inline-block rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    <h5 class="pl-6 -ml-6 border-l-4 border-l-blue-500 mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $isLimitHeight ? Str::limit($project->title, 30) : $project->title}}</h5>
    <p class="font-normal text-gray-700 dark:text-gray-400">{{$isLimitHeight ? Str::limit($project->description) : $project->description}}</p>
</a>
