<nav>
    <a href="{{ route('bo.') }}" target="_blank">Connecter</a>
    <a href="{{ route('homepage') }}">Home</a>
    @foreach ($games as $key => $folder)
        @if (count($folder) > 1)
            <div>
                {{ $folder[0]->folder->name }}
                @include('layouts.frontend.nav-list')
            </div>
        @else
            @include('layouts.frontend.nav-list')
        @endif
    @endforeach
</nav>
