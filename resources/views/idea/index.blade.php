<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold tracking-tight">Ideas</h1>
            <p class="text-muted-foreground mt-2">Capture your thoughts. Make a plan.</p>

            <x-card
                is='button'
                class="mt-10 space-y-3 cursor-pointer h-32 w-full"
                id="btn"
                data-test="create-idea-button"
            >
                What's the idea?
            </x-card>
        </header>
    </div>

    <div>

        <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">All</a>
        @foreach (App\IdeaStatus::cases() as $status)
            <a href="/ideas?status={{ $status->value }}" class="btn {{ request('status')=== $status->value ? '' : 'btn-outlined' }}">
                {{ $status->label() }} <span class="text-xs pl-3">{{ $statusCount->get($status->value) }}</span>
            </a>
        @endforeach

    </div>

    <div class="mt-10 text-muted-foreground">
        <div class="grid md:grid-cols-2 gap-6">

            @forelse ($ideas as $idea)
                {{-- <x-card href="/ideas/{{ $idea->id }}"> --}}
                <x-card href="{{ route('idea.show', $idea ) }}">
                    @if ($idea->image_path)
                    <div class="mb-4 -mx-4 -mt-4 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}" class="w-full h-auto object-cover">
                    </div>
                    @endif
                    <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>
                    <div class="mt-2">
                        <x-idea.status-label status="{{ $idea->status }}">
                            {{ $idea->status->label() }}
                        </x-idea.status-label>
                    </div>
                    <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                    <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                </x-card>
            @empty
                <x-card>
                    <p>No ideas at this time.</p>
                </x-card>
            @endforelse

        </div>

        <x-idea.modal />

    </div>

</x-layout>
