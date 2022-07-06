<nav>
    <a href="{{ route('bo.') }}" target="_blank">Connecter</a>
    <a href="{{ route('homepage') }}">Home</a>
    @foreach ($games as $key => $game)
        <a href="{{ route('games.specific', $game->slug) }}">
            {{ $game->name }}
            <span>
                @if (isset($game->pictures))
                    {{ count($game->pictures) }}
                @else
                    0
                @endif
            </span>
        </a>
    @endforeach
</nav>
