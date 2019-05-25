@if ($errors->any())
    <div class="bg-red-400 px-4 py-2 mb-6 text-white rounded">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
