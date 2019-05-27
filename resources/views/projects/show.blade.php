@extends('layouts.app')

@section('content')
    <header class="flex items-end mb-3 py-2">
        <p class="text-gray-600 text-lg">
            <a href="{{ route('projects.index') }}">My projects</a> / {{ $project->title }}
        </p>
        <div class="ml-auto flex items-center">
            @foreach ($project->members as $member)
                <img
                        src="{{ gravatar_url($member->email) }}"
                        alt="{{ $member->name }}'s avatar"
                        class="rounded-full w-8 h-8 mr-2">
            @endforeach

            <img
                    src="{{ gravatar_url($project->owner->email) }}"
                    alt="{{ $project->owner->name }}'s avatar"
                    class="rounded-full w-8 h-8 mr-2">

            <a href="{{ route('projects.edit', $project) }}" class="ml-4 button button--blue">Edit project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-gray-600 text-lg mb-2">Tasks</h2>
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="flex items-center">
                                    <input type="text" value="{{ $task->body }}" name="body" class="w-full{{ $task->completed ? ' text-gray-500' : '' }}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()"{{ $task->completed ? ' checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ route('project.tasks.store', $project) }}" method="POST">
                            @csrf
                            <input name="body" type="text" placeholder="Add a new task..." class="w-full">
                        </form>
                    </div>
                </div>

                <h2 class="text-gray-600 text-lg mb-2">General notes</h2>

                <form action="{{ $project->path() }}" method="POST">
                    @csrf
                    @method('PUT')

                    <textarea
                            name="notes"
                            class="card w-full h-56 mb-4"
                            placeholder="Enter something special to make a note of..."
                    >{{ $project->notes }}</textarea>

                    <button type="submit" class="button button--blue">Save</button>
                </form>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects._card')
                @include('projects.activity._card')
            </div>
        </div>
    </main>
@endsection
