@foreach ($folder as $item)
    <li class="list-group-item @if ($inFolder) list-group-folder @endif border-0 bg-second bg-transparent p-0">
        <a href="{{ route('games.specific', $item->slug) }}"
            class="btn border-0 d-flex flex-row justify-content-start align-items-center text-first text-decoration-none p-2 @if ($inFolder) ps-3 @endif @if ($item->slug === $game->slug) game-selected disabled @endif"
            data-bs="tooltip"
            data-bs-placement="right"
            title="{{ __('nav.list_game', ['number' => (isset($item->pictures)) ? count($item->pictures) : 0, 'game' => $item->name]) }}">
            @if ($inFolder)
                <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"/>
                </svg>
            @endif
            <span>{{ $item->name }}</span>
        </a>
    </li>
@endforeach
