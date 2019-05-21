@extends('layouts.app')

@section('content')
    <a href="{{ route('projects.create') }}">Create project</a>

    <ul>
        @forelse ($projects as $project)
            <li>
                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            </li>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </ul>
@endsection
