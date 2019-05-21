@extends('layouts.app')

@section('content')
    <h1>Create a Project</h1>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="field">
            <label for="title" class="label">Title</label>

            <div class="control">
                <input id="title" type="text" class="input" name="title" placeholder="Title">
            </div>
        </div>

        <div class="field">
            <label for="description" class="label">Description</label>

            <div class="control">
                <input id="description" type="text" class="input" name="description" placeholder="Description">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Create Project</button>
            </div>
        </div>
    </form>
@endsection
