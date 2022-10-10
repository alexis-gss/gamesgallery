@auth
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.homepage')) active @endif" href="{{ route('bo.homepage') }}"
                title="{{ __('sidenav.title_home') }}" data-bs="tooltip"
                data-bs-placement="bottom">{{ __('sidenav.home') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.games.*')) active @endif" href="{{ route('bo.games.index') }}"
                title="{{ __('sidenav.title_list_games', ['games' => count($globalGames)]) }}" data-bs="tooltip"
                data-bs-placement="bottom">{{ __('sidenav.list_games') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.folders.*')) active @endif" href="{{ route('bo.folders.index') }}"
                title="{{ __('sidenav.title_list_folders', ['folders' => count($globalFolders)]) }}" data-bs="tooltip"
                data-bs-placement="bottom">{{ __('sidenav.list_folders') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.users.*')) active @endif" href="{{ route('bo.users.index') }}"
                title="{{ __('sidenav.title_list_users', ['users' => count($globalUsers)]) }}" data-bs="tooltip"
                data-bs-placement="bottom">{{ __('sidenav.list_users') }}</a>
        </li>
    </ul>
@endauth
