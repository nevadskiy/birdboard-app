@extends('layouts.app')

@section('content')
    <form
            action="{{ route('projects.update', $project) }}"
            method="POST"
            class="lg:w-1/2 lg:mx-auto card"
    >
        @csrf
        @method('PUT')

        <h1 class="text-2xl font-normal mb-10 text-center">Edit your project</h1>

        @include('projects._validation')

        <div class="mb-6">
            <label for="title" class="text-sm mb-2 block">Title</label>
            <input
                    id="title"
                    name="title"
                    class="bg-card-input border border-card-input rounded p-2 text-sm w-full"
                    type="text"
                    placeholder="Title"
                    value="{{ old('title', $project->title) }}"
            >
        </div>

        <div class="mb-6">
            <label for="description" class="text-sm mb-2 block">Description</label>
            <textarea
                    id="description"
                    name="description"
                    rows="10"
                    class="block bg-card-input border border-card-input rounded p-2 text-sm w-full"
                    type="text"
                    placeholder="Description"
            >{{ old('description', $project->description) }}</textarea>
        </div>

        <button type="submit" class="button button-primary mr-2">Update project</button>
        <a href="{{ $project->path() }}">Cancel</a>
    </form>
@endsection
