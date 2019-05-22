@extends('layouts.app')

@section('content')
    <header class="flex items-end mb-3 py-2">
        <p class="text-gray-600 mr-auto text-lg">
            <a href="{{ route('projects.index') }}">My projects</a> / {{ $project->title }}
        </p>
        <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create project</a>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-gray-600 text-lg mb-2">Tasks</h2>
                    <div class="card mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto blanditiis consectetur delectus, distinctio dolorem dolorum earum eligendi facilis hic incidunt ipsam laborum molestias neque nisi obcaecati quae quidem rem soluta?</div>
                    <div class="card mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto blanditiis consectetur delectus, distinctio dolorem dolorum earum eligendi facilis hic incidunt ipsam laborum molestias neque nisi obcaecati quae quidem rem soluta?</div>
                    <div class="card mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto blanditiis consectetur delectus, distinctio dolorem dolorum earum eligendi facilis hic incidunt ipsam laborum molestias neque nisi obcaecati quae quidem rem soluta?</div>
                    <div class="card mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto blanditiis consectetur delectus, distinctio dolorem dolorum earum eligendi facilis hic incidunt ipsam laborum molestias neque nisi obcaecati quae quidem rem soluta?</div>
                </div>

                <h2 class="text-gray-600 text-lg mb-2">General notes</h2>

                <textarea class="card w-full h-56">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto blanditiis consectetur delectus, distinctio dolorem dolorum earum eligendi facilis hic incidunt ipsam laborum molestias neque nisi obcaecati quae quidem rem soluta?</textarea>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects._card')
            </div>
        </div>
    </main>
@endsection
