<nav class="nav position-fixed start-50 translate-middle-x d-flex flex-column justify-content-center align-items-center bg-fourth rounded-3 p-1 pt-0">
    <!-- List of games -->
    <div class="nav-modal nav-modal-hidden col bg-third rounded-3 w-100 mt-1 p-3">
        @php
            $dataGame = [
                'games' => $games,
                'gamesCount' => count($games)
            ];
        @endphp
        <div class="games-list" data-json='@json($dataGame)'></div>
    </div>
    <!-- Buttons -->
    <button class="btn btn-games d-flex flex-row justify-content-start align-items-center bg-third rounded-2 text-first border-0 w-100 mt-1 p-0">
        <span class="p-3">
            <svg width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </span>
        <a class="d-flex flex-row align-items-center text-second text-decoration-none py-3" href="{{ route('homepage') }}">
            <span class="overflow-hidden">homepage</span>
        </a>
        <span class="overflow-hidden text-start w-100 p-3 ps-0">/{{ $game->slug }}</span>
    </button>
</nav>
