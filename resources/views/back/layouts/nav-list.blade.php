@auth
<ul class="navbar-nav me-auto">
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.homepage')) fw-bold @endif"
            href="{{ route('bo.homepage') }}"
            title="{{ __('texts.bo.tooltip.homepage') }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('texts.bo.other.homepage') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.statistics')) fw-bold @endif"
            href="{{ route('bo.statistics') }}"
            title="{{ __('texts.bo.tooltip.statistics') }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('models.stats') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.games.*')) fw-bold @endif"
            href="{{ route('bo.games.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalGames), 'model' => __('models.games')]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('models.games') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.folders.*')) fw-bold @endif"
            href="{{ route('bo.folders.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalFolders), 'model' => __('models.folders')]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('models.folders') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.tags.*')) fw-bold @endif"
            href="{{ route('bo.tags.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalTags), 'model' => __('models.tags')]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('models.tags') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark @if (request()->routeIs('bo.users.*')) fw-bold @endif"
            href="{{ route('bo.users.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalUsers), 'model' => __('models.users')]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('models.users') }}
        </a>
    </li>
</ul>
@endauth
