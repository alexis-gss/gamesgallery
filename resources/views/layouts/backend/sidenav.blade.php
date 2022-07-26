<nav id="sidebarMenu" class="col-md-4 w-fit">
    <div class="sidebar-sticky pt-2 d-flex flex-column justify-content-between align-items-center">
        <div class="col-12">
            <div class="accordion" id="accordionHome">
                <div class="accordion-item mb-1">
                    <div class="accordion-body">
                        <a class="nav-link py-0 p-0 pb-1 mb-1 border-bottom" href="{{ route('bo.home') }}"
                            data-bs="tooltip" data-bs-placement="right"
                            title="{{ __('sidenav.title_home') }}">{{ __('sidenav.home') }}</a>
                        {{-- GAMES --}}
                        <h6 class="pb-1 mb-1 mt-3 text-dark border-bottom fw-bold">{{ __('sidenav.games') }}</h6>
                        @can('isAdmin')
                            <a class="nav-link py-0 px-0 mx-4" data-bs="tooltip" data-bs-placement="right"
                                title="{{ __('sidenav.title_create_game') }}"
                                href="{{ route('bo.games.create') }}">{{ __('sidenav.add_game') }}</a>
                        @endcan
                        <a class="nav-link py-0 px-0 mx-4 pb-1 mb-1 border-bottom" data-bs="tooltip"
                            data-bs-placement="right" title="{{ __('sidenav.title_list_games') }}"
                            href="{{ route('bo.games.index') }}">{{ __('sidenav.list_games') }}</a>
                        @can('isAdmin')
                            <a class="nav-link py-0 px-0 mx-4" data-bs="tooltip" data-bs-placement="right"
                                title="{{ __('sidenav.title_create_folder') }}"
                                href="{{ route('bo.folders.create') }}">{{ __('sidenav.add_folder') }}</a>
                        @endcan
                        <a class="nav-link py-0 px-0 mx-4" data-bs="tooltip" data-bs-placement="right"
                            title="{{ __('sidenav.title_list_folders') }}"
                            href="{{ route('bo.folders.index') }}">{{ __('sidenav.list_folders') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
