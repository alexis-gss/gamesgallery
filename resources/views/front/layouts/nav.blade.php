<nav
    class="nav position-fixed start-50 translate-middle-x d-flex flex-column justify-content-center align-items-center bg-secondary shadow rounded-3 p-2 pt-0">
    <!-- List of games -->
    <div class="nav-modal nav-modal-hidden col bg-third rounded-3 w-100 p-0">
        @include('front.partials.games-search')
    </div>
    <!-- Buttons -->
    <button
        class="btn d-flex justify-content-start align-items-center bg-primary rounded-2 text-light w-100 mt-2 flex-row overflow-hidden border-0 p-0">
        <span class="btn-games p-3">
            <i class="fa-solid fa-bars"></i>
        </span>
        @include('./../../breadcrumbs/breadcrumb-body')
        <span
            class="btn btn-scroll text-light bg-primary border-top-0 border-end-0 border-bottom-0 border-secondary rounded-start-0 btn-scroll-hidden border p-3">
            <i class="fa-solid fa-arrow-up"></i>
        </span>
    </button>
</nav>

<div class="nav-filter nav-filter-hidden position-fixed w-100 h-100 bg-dark start-0 top-0"></div>
