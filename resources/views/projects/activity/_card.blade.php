<div class="card mt-4">
    <ul class="text-sm">
        @foreach ($project->activity as $activity)
            <li>
                @include("projects.activity.{$activity->description}")
                <span class="text-gray-700">{{ $activity->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>
</div>
