@extends('layouts.app')

@section('content')
    <form
            action="{{ route('projects.store') }}"
            method="POST"
            class="lg:w-1/2 lg:mx-auto card"
    >
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">Create your project</h1>

        @include('projects._validation')

        <div class="mb-6">
            <label for="title" class="text-sm mb-2 block">Title</label>
            <input
                    id="title"
                    name="title"
                    class="bg-card-input border border-card-input rounded p-2 text-sm w-full"
                    type="text"
                    placeholder="Title"
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
            ></textarea>
        </div>

        <button type="submit" class="button button-primary mr-2">Create project</button>
        <a href="{{ route('projects.index') }}">Cancel</a>
    </form>
@endsection
