@extends('layouts.app')

@section('content')
    <form
            action="{{ route('projects.update', $project) }}"
            method="POST"
            class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow"
    >
        @csrf
        @method('PUT')

        <h1 class="text-2xl font-normal mb-10 text-center">Edit your project</h1>

        <div class="mb-6">
            <label for="title" class="text-sm mb-2 block">Title</label>
            <input
                    id="title"
                    name="title"
                    class="bg-transparent border border-gray-400 rounded p-2 text-sm w-full"
                    type="text"
                    placeholder="Title"
                    value="{{ $project->title }}"
            >
        </div>

        <div class="mb-6">
            <label for="description" class="text-sm mb-2 block">Description</label>
            <textarea
                    id="description"
                    name="description"
                    rows="10"
                    class="block bg-transparent border border-gray-400 rounded p-2 text-sm w-full"
                    type="text"
                    placeholder="Description"
            >{{ $project->description }}</textarea>
        </div>

        <button type="submit" class="button button--blue mr-2">Update project</button>
        <a href="{{ $project->path() }}">Cancel</a>
    </form>
@endsection
