<div class="card flex flex-col">
    <h3 class="font-normal text-xl mb-3 py-1 px-3 border-blue-400 border-l-4 -ml-3">
        Invite a User
    </h3>

    <form action="{{ route('project.invitations.store', $project) }}" method="POST">
        @csrf

        @include('projects._validation', ['bag' => 'invitations'])

        <div class="mb-3">
            <input
                    type="email"
                    name="email"
                    class="border border-card-input rounded w-full py-2 px-3 bg-card-input"
                    placeholder="Email address"
            >
        </div>

        <button class="button button-primary">Invite</button>
    </form>
</div>
