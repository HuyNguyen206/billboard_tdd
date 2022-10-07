<x-app-layout>
    <div class="bg-card mt-2 p-4 rounded">
        <h1 class="text-xl font-bold text-default-color">Create project</h1>
        <form method="post" action="{{route('projects.store')}}">
            @csrf
            @include('partial.project-form')
            <button class="bg-button text-default-color hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            <a href="{{route('projects.index')}}" class="text-default-color bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cancel</a>
        </form>
    </div>
</x-app-layout>

