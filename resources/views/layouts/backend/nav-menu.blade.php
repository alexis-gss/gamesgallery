@auth
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.home')) active @endif" href="{{ route('bo.home') }}"
                title="{{ __('sidenav.title_home') }}" data-bs="tooltip"
                data-bs-placement="bottom">{{ __('sidenav.home') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.games.*')) active @endif" href="{{ route('bo.games.index') }}"
                title="{{ __('sidenav.title_list_games') }}" data-bs="tooltip"
                data-bs-placement="bottom">{{ __('sidenav.list_games') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.folders.*')) active @endif" href="{{ route('bo.folders.index') }}"
                title="{{ __('sidenav.title_list_folders') }}" data-bs="tooltip"
                data-bs-placement="bottom">{{ __('sidenav.list_folders') }}</a>
        </li>
    </ul>
@endauth
