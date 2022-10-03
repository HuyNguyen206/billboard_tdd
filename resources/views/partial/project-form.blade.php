<div class="mb-6">
    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your title</label>
    <input value="{{old('title', $project->title)}}" name="title" type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
    @error('title')
    <p id="standard_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
        {{$message}}
    </p>
    @enderror
</div>
<div class="mb-6">
    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your description</label>
    <textarea name="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="" cols="30" rows="10">{{old('description', $project->description)}}</textarea>
    @error('description')
    <p id="standard_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
        {{$message}}
    </p>
    @enderror
</div>
