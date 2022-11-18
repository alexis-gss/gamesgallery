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
    <div class="d-flex flex-row justify-content-center align-items-center mx-auto w-100 mt-1">
        <button class="btn btn-games d-flex flex-row justify-content-between align-items-center text-first text-start text-lowercase bg-third border-0 p-3">
            <span class="overflow-hidden">{{ $game->name }}</span>
        </button>
        <button class="btn btn-scroll text-first bg-third border-0 p-3 ms-1">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
            </svg>
        </button>
    </div>
</nav>
