<x-app-layout>
    <div>
        <div class="flex justify-between items-center my-4">
            <h1 class="font-bold text-xl text-gray-400">My projects</h1>
            <livewire:create-project/>
{{--            <button @click.prevent="show = true" class="px-4 py-2 rounded-full bg-blue-600 text-white" >Create a new project</button>--}}
{{--            <a class="px-4 py-2 rounded-full bg-blue-600 text-white" href="{{route('projects.create')}}">Create a new project</a>--}}
        </div>
        <div class="lg:flex lg:flex-wrap">
            @foreach($projects as $project)
                <div class="lg:w-1/3 px-2 py-2">
                    <x-card :project="$project"></x-card>
                </div>
            @endforeach
            {{$projects->links()}}
        </div>

    </div>
</x-app-layout>
