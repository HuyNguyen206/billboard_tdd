<x-app-layout>
    <div>
        <h1 class="text-xl font-bold">Edit project</h1>
        <form method="post" action="{{route('projects.update', $project->id)}}">
            @method('put')
            @csrf
            @include('partial.project-form')
            <button class="text-white bg-button  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
            <a href="{{route('projects.index')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cancel</a>

        </form>
    </div>
</x-app-layout>

