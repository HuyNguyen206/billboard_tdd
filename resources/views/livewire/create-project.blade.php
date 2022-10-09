@php
use App\Models\Project;
$project = new Project();
@endphp
<div class="bg-page" x-data="{
     show:  @entangle('show'),
     tasks: @entangle('tasks').defer,
     submitted: false
}">
    <!-- Modal toggle -->
    <button wire:click="initModel" class="px-4 py-2 rounded-full bg-blue-600 text-white" >Create a new project</button>
    <div x-show="show" @project-created.window="show = false" class="flex absolute top-0 left-0 justify-center items-center z-20 bg-gray-600/50 w-screen h-screen">
        <div @click.outside="show=false" class="bg-page mt-2 p-4 rounded w-[46.25rem]">
            <h1 class="text-xl font-bold text-default-color">Create project</h1>
            <form wire:submit.prevent="createProject" @>
                @csrf
                @include('partial.project-modal-form', compact('project'))
                <button @click="submitted = true" :class="submitted && 'cursor-not-allowed focus:outline-none disabled:opacity-75'" class="bg-button text-default-color focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                <button @click.prevent="show=false" class="bg-button text-default-color focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cancel</button>
            </form>
        </div>
    </div>
    <!-- Main modal -->
</div>

