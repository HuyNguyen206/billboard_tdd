@props([
 'project' => $project,
 'isLimitHeight' => true
])
<div @if($isLimitHeight) style="height: 200px"
     @endif class="w-full relative bg-card p-6 inline-block rounded-lg shadow-md z-10">
    @if($project->hasMember(auth()->user()))
        <span
            class="inline-block float-right mr-2 mb-4 bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Shared project</span>

    @else
        <span
            class="inline-block float-right mr-2 mb-4 bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">Owned</span>
    @endif
    <a href="{{route('projects.show', $project->id)}}"
       class="text-default-color pl-6 -ml-6 border-l-4 border-l-blue-500 mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $isLimitHeight ? Str::limit($project->title, 30) : $project->title}}</a>
    <p class="font-normal text-default-color dark:text-gray-400">{{$isLimitHeight ? Str::limit($project->description) : $project->description}}</p>
    @can('delete', $project)
        <form action="{{route('projects.destroy', $project->id)}}" method="post">
            @csrf
            @method('delete')
            <button class="text-red-700 absolute right-0 bottom-0 mr-2 mb-2">Delete</button>
        </form>
    @endcan

</div>
