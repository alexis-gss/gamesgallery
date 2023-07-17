<nav class="nav position-fixed start-50 translate-middle-x d-flex flex-column justify-content-center align-items-center bg-secondary rounded-3 p-2 pt-0">
    <!-- List of games -->
    <div class="nav-modal nav-modal-hidden col bg-third rounded-3 w-100 p-0">
        @php
        $dataGame = [
            'games' => $games,
            'gamesCount' => count($games),
            'allTags' => $globalTags,
            'allFolders' => $globalFolders
        ];
        @endphp
        <div class="games-list mt-2" data-json='@json($dataGame)'></div>
    </div>
    <!-- Buttons -->
    <button class="btn d-flex flex-row justify-content-start align-items-center bg-primary rounded-2 text-light border-0 w-100 mt-2 p-0">
        <span class="btn-games p-3">
            <i class="fa-solid fa-bars"></i>
        </span>
        @include('./../../breadcrumbs/breadcrumb-body')
    </button>
</nav>

<div class="nav-filter nav-filter-hidden position-fixed top-0 start-0 w-100 h-100 bg-primary"></div>

<!-- Button to scroll to the top -->
<div class="btn-scroll btn-scroll-hidden d-none d-lg-block position-fixed bg-secondary rounded-2 p-2">
    <button class="btn text-light bg-primary border-0 p-3">
        <i class="fa-solid fa-arrow-up"></i>
    </button>
</div>
