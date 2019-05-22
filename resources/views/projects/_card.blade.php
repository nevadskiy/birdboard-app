<div class="card overflow-hidden h-40">
    <h3 class="font-normal text-xl mb-3 py-1 px-3 border-blue-400 border-l-4 -ml-3">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>
    <div class="text-gray-500">{{ Str::limit($project->description, 200) }}</div>
</div>
