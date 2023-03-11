<nav class="nav position-fixed start-50 translate-middle-x d-flex flex-column justify-content-center align-items-center bg-fourth rounded-3 p-1 pt-0">
    <!-- List of games -->
    <div class="nav-modal nav-modal-hidden col bg-third rounded-3 w-100 mt-1 p-3 pt-0">
        @php
            $dataGame = [
                'games' => $games,
                'gamesCount' => count($games),
                'allTags' => $globalTags,
                'allFolders' => $globalFolders
            ];
        @endphp
        <div class="games-list" data-json='@json($dataGame)'></div>
    </div>
    <!-- Buttons -->
    <button class="btn d-flex flex-row justify-content-start align-items-center bg-third rounded-2 text-first border-0 w-100 mt-1 p-0">
        <span class="btn-games p-3">
            <i class="fa-solid fa-bars"></i>
        </span>
        @include('./../../breadcrumbs/breadcrumb-body')
    </button>
</nav>

<!-- Button to scroll to the top -->
<div class="btn-scroll d-none d-lg-block position-fixed bg-fourth rounded-2 p-1">
    <button class="btn text-first bg-third border-0 p-3">
        <i class="fa-solid fa-arrow-up"></i>
    </button>
</div>
