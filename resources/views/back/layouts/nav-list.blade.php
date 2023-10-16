@auth
<ul class="navbar-nav me-auto">
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('bo.homepage')) fw-bold @endif"
            href="{{ route('bo.homepage') }}"
            title="{{ __('texts.bo.tooltip.homepage') }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ __('texts.bo.other.homepage') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('bo.statistics')) fw-bold @endif"
            href="{{ route('bo.statistics') }}"
            title="{{ __('texts.bo.tooltip.statistics', ['model' => Str::of(__('models.statistic'))->plural()]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ Str::of(__('models.statistic'))->plural()->ucfirst() }}
        </a>
    </li>
    @can('viewAny', \App\Models\ActivityLog::class)
    <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('bo.activity_logs.*')) fw-bold @endif"
            href="{{ route('bo.activity_logs.index') }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalActivities), 'model' => Str::of(trans_choice('models.activity_log', 2))]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ Str::of(trans_choice('models.activity_log', 2))->ucfirst() }}
        </a>
    </li>
    @endcan
    @can('viewAny', \App\Models\Game::class)
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('bo.games.*')) fw-bold @endif"
            href="{{ route('bo.games.index') }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalGames), 'model' => Str::of(__('models.game'))->plural()]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ Str::of(__('models.game'))->plural()->ucfirst() }}
        </a>
    </li>
    @endcan
    @can('viewAny', \App\Models\Folder::class)
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('bo.folders.*')) fw-bold @endif"
            href="{{ route('bo.folders.index') }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalFolders), 'model' => Str::of(__('models.folder'))->plural()]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ Str::of(__('models.folder'))->plural()->ucfirst() }}
        </a>
    </li>
    @endcan
    @can('viewAny', \App\Models\Tag::class)
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('bo.tags.*')) fw-bold @endif"
            href="{{ route('bo.tags.index') }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalTags), 'model' => Str::of(__('models.tag'))->plural()]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ Str::of(__('models.tag'))->plural()->ucfirst() }}
        </a>
    </li>
    @endcan
    @can('viewAny', \App\Models\Rank::class)
    <li class="nav-item">
        <a class="nav-link @if (request()->routeIs('bo.ranks.*')) fw-bold @endif"
            href="{{ route('bo.ranks.index') }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalRanks), 'model' => Str::of(__('models.rank'))->plural()]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ Str::of(__('models.rank'))->plural()->ucfirst() }}
        </a>
    </li>
    @endcan
    @canAny(['isConceptor', 'viewAny'], \App\Models\User::class)
    <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('bo.users.*')) fw-bold @endif"
            href="{{ route('bo.users.index') }}"
            title="{{ __('texts.bo.tooltip.list_models', ['count' => count($globalUsers), 'model' => Str::of(__('models.user'))->plural()]) }}"
            data-bs="tooltip"
            data-bs-placement="bottom">
            {{ Str::of(__('models.user'))->plural()->ucfirst() }}
        </a>
    </li>
    @endcan
</ul>
@endauth
