@auth
<ul class="navbar-nav me-auto">
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.homepage')) fw-bold @endif"
            href="{{ route('bo.homepage') }}"
            title="{{ __('nav.title_home') }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('nav.home') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.statistics')) fw-bold @endif"
            href="{{ route('bo.statistics') }}"
            title="{{ __('nav.title_list_statistics') }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('nav.list_statistics') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.games.*')) fw-bold @endif"
            href="{{ route('bo.games.index') }}"
            title="{{ __('nav.title_list_games', ['games' => count($globalGames)]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('nav.list_games') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.folders.*')) fw-bold @endif"
            href="{{ route('bo.folders.index') }}"
            title="{{ __('nav.title_list_folders', ['folders' => count($globalFolders)]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('nav.list_folders') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.tags.*')) fw-bold @endif"
            href="{{ route('bo.tags.index') }}"
            title="{{ __('nav.title_list_tags', ['tags' => count($globalTags)]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('nav.list_tags') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.users.*')) fw-bold @endif"
            href="{{ route('bo.users.index') }}"
            title="{{ __('nav.title_list_users', ['users' => count($globalUsers)]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('nav.list_users') }}
        </a>
    </li>
</ul>
@endauth
