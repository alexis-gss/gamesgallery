<nav id="sidebarMenu" class="col-md-4 w-fit">
    <div class="sidebar-sticky pt-2 d-flex flex-column justify-content-between align-items-center">
        <div class="col-12">
            <div class="accordion" id="accordionHome">
                <div class="accordion-item mb-1">
                    <div class="accordion-body">
                        <a class="nav-link py-0 p-0 pb-1 mb-1 border-bottom"
                            href="{{ route('bo.home') }}">{{ __('Home') }}</a>
                        {{-- GAMES --}}
                        <h6 class="pb-1 mb-1 mt-3 text-dark border-bottom">{{ __('Games') }}</h6>
                        @can('isAdmin')
                            <a class="nav-link py-0 px-0 mx-4"
                                href="{{ route('bo.games.create') }}">{{ __('Add_game') }}</a>
                        @endcan
                        <a class="nav-link py-0 px-0 mx-4 pb-1 mb-1 border-bottom"
                            href="{{ route('bo.games.index') }}">{{ __('List_games') }}</a>
                        @can('isAdmin')
                            <a class="nav-link py-0 px-0 mx-4"
                                href="{{ route('bo.folders.create') }}">{{ __('Add_folder') }}</a>
                        @endcan
                        <a class="nav-link py-0 px-0 mx-4"
                            href="{{ route('bo.folders.index') }}">{{ __('List_folders') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
