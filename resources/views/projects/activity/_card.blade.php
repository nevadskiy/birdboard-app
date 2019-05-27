<div class="card mt-4 mb-4">
    <ul class="text-sm">
        @foreach ($project->activity as $activity)
            <li class="mb-2">
                @include("projects.activity.{$activity->description}")
                <div class="text-gray-500 whitespace-no-wrap">{{ $activity->created_at->diffForHumans() }}</div>
            </li>
        @endforeach
    </ul>
</div>
