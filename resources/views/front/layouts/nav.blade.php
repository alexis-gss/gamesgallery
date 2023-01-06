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
            <i class="fa-solid fa-bars"></i>
        </span>
        <a class="d-flex flex-row align-items-center text-second text-decoration-none py-3" href="{{ route('homepage') }}">
            <span class="overflow-hidden">homepage</span>
        </a>
        <span class="overflow-hidden text-start w-100 p-3 ps-0">/{{ $game->slug }}</span>
    </button>
</nav>
