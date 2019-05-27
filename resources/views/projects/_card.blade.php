<div class="card overflow-hidden h-40 flex flex-col">
    <h3 class="font-normal text-xl mb-3 py-1 px-3 border-blue-400 border-l-4 -ml-3">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>

    <div class="text-gray-500 mb-4">{{ Str::limit($project->description, 200) }}</div>

    <footer class="mt-auto">
       @can('own', $project)
            <form action="{{ $project->path() }}" method="POST" class="text-right">
                @csrf
                @method('DELETE')

                <button class="text-xs">Delete</button>
            </form>
        @endcan
    </footer>
</div>
