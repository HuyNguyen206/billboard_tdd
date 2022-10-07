@props([
    'project'
])
<div class="p-6 bg-card text-default-color rounded-lg my-2 shadow" >
    <h2>Invite user</h2>
    <form class="mt-1" method="post" action="{{route('projects.invite', $project->id)}}">
        @csrf
        <div>
            <label for="first_name"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
            <input type="email" id="first_name"
                   name="email"
                   class="w-full bg-card text-default-color text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="Email" required="">
        </div>
        @error('email')
        <p id="standard_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
            {{$message}}
        </p>
        @enderror
        <button type="submit"
                class="mt-2 text-default-color bg-button focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Submit
        </button>
    </form>

</div>
