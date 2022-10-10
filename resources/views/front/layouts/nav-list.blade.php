@foreach ($folder as $item)
    <a href="{{ route('games.specific', $item->slug) }}"
        class="game @if ($item->slug === $game->slug) nav-activated @endif"
        title="{{ __('nav.list_game', ['game' => $item->name]) }}">
        <svg>
            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
        </svg>
        {{ $item->name }}
        <span>
            @if (isset($item->pictures))
                ({{ count($item->pictures) }})
            @else
                (0)
            @endif
        </span>
    </a>
@endforeach
