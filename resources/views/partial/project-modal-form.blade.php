<div class="flex">
    <div class="w-1/2 p-2">
        <label for="email" class="block mb-2 text-sm font-medium text-default-color">Your title</label>
        <input wire:model="title" type="text" id="title"
               class="bg-card text-default-color text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        @error('title')
        <p id="standard_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
            {{$message}}
        </p>
        @enderror

        <label for="password" class="block my-2 text-sm font-medium text-default-color">Your description</label>
        <textarea wire:model="description" class="bg-card text-default-color text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="" cols="30" rows="10">{{old('description', $project->description)}}</textarea>
        @error('description')
        <p id="standard_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
            {{$message}}
        </p>
        @enderror
    </div>
    <div class="w-1/2 p-2">
        <div class="mt-2">
            <template x-for="(task, index) in tasks" :key="index">
                <input x-model="task.body" type="text" placeholder="Add new task..."
                       class="mt-1 bg-card text-default-color w-full border-none">
            </template>
            <div class="flex space-x-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <button @click.prevent="tasks.push({body: ''})"
                        class="mt-2 bg-button text-default-color focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add task
                </button>
            </div>
        </div>
    </div>
</div>
