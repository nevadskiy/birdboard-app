@extends('layouts.app')

@section('content')
    <a href="{{ route('projects.create') }}">Create project</a>

    <div class="flex">
        @forelse ($projects as $project)
            <div class="bg-white mr-4 rounded shadow w-1/3 p-3 overflow-hidden h-40">
                <h3 class="font-normal text-2xl mb-3 py-3">{{ $project->title }}</h3>
                <div class="text-gray-500">{{ Str::limit($project->description) }}</div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
@endsection
