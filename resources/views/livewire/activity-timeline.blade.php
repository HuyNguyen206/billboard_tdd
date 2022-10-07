<div class="mt-2">
    <ul class="w-full bg-card text-default-color text-sm font-medium rounded-lg">
        @foreach($project->activities as $activity)
            <li class="py-2 px-4 w-full rounded-t-lg">{{ $activity->description_extend }}
                <span class="font-bold">{{$activity->des_detail}}</span>
                <span class="text-gray-400">{{$activity->at_date}}</span>
            </li>
        @endforeach
    </ul>
</div>
