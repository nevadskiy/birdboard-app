@extends('layouts.app')

@section('content')
    <header class="flex items-end mb-3 py-2">
        <h2 class="text-gray-600 mr-auto text-lg">
            <a href="{{ route('projects.index') }}">Projects</a>
        </h2>
        <a href="{{ route('projects.create') }}" class="button button-primary">Create project</a>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-2">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-2 mb-4">
                @include('projects._card')
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </main>
@endsection
