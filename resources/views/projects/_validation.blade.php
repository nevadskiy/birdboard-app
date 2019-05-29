@if ($errors->{ $bag ?? 'default' }->any())
    <div class="bg-danger px-4 py-2 mb-6 text-white rounded">
        @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
