<div class="mt-2">
    <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        @foreach($project->activities as $activity)
            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">{{ $activity->activity_des }}
                <span class="font-bold">{{$activity->des_detail}}</span>
                <span class="text-gray-400">{{$activity->at_date}}</span>
            </li>

        @endforeach
    </ul>
</div>
