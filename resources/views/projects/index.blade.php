@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-2">
        <h1 class="text-gray-600 mr-auto text-lg">Projects</h1>
        <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create project</a>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-2">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-2 pb-4">
                <div class="bg-white rounded shadow px-3 py-4 overflow-hidden h-40">
                    <h3 class="font-normal text-xl mb-3 py-1 px-3 border-blue-400 border-l-4 -ml-3">
                        <a href="{{ $project->path() }}">{{ $project->title }}</a>
                    </h3>
                    <div class="text-gray-500">{{ Str::limit($project->description) }}</div>
                </div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </main>
@endsection
