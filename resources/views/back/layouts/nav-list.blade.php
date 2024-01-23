@auth
    <ul class="navbar-nav border-top border-xl-0 mt-xl-0 me-auto mt-2">
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.homepage')) fw-bold @endif text-center" data-bs-tooltip="tooltip" data-bs-placement="bottom"
                href="{{ route('bo.homepage') }}" title="{{ __('bo_tooltip_homepage') }}">
                {{ __('bo_other_homepage') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('bo.statistics.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip" data-bs-placement="bottom"
                href="{{ route('bo.statistics.index') }}"
                title="{{ __('bo_tooltip_statistics', ['model' => Str::of(__('models.statistic'))->plural()]) }}">
                {{ Str::of(__('models.statistic'))->plural()->ucfirst() }}
            </a>
        </li>
        @can('viewAny', \App\Models\Game::class)
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('bo.games.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip"
                    data-bs-placement="bottom" href="{{ route('bo.games.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalGames), 'model' => trans_choice('models.game', 2)]) }}">
                    {{ Str::of(trans_choice('models.game', 2))->ucfirst() }}
                </a>
            </li>
        @endcan
        @can('viewAny', \App\Models\Folder::class)
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('bo.folders.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip"
                    data-bs-placement="bottom" href="{{ route('bo.folders.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalFolders), 'model' => Str::of(__('models.folder'))->plural()]) }}">
                    {{ Str::of(__('models.folder'))->plural()->ucfirst() }}
                </a>
            </li>
        @endcan
        @can('viewAny', \App\Models\Tag::class)
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('bo.tags.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip"
                    data-bs-placement="bottom" href="{{ route('bo.tags.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalTags), 'model' => Str::of(__('models.tag'))->plural()]) }}">
                    {{ Str::of(__('models.tag'))->plural()->ucfirst() }}
                </a>
            </li>
        @endcan
        @can('viewAny', \App\Models\Rank::class)
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('bo.ranks.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip"
                    data-bs-placement="bottom" href="{{ route('bo.ranks.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalRanks), 'model' => Str::of(__('models.rank'))->plural()]) }}">
                    {{ Str::of(__('models.rank'))->plural()->ucfirst() }}
                </a>
            </li>
        @endcan
        @canAny(['isConceptor', 'viewAny'], \App\Models\ActivityLog::class)
            <li class="nav-item dropdown">
                <button
                    class="btn nav-link dropdown-toggle d-flex align-items-center justify-content-center w-100 h-100 rounded-0 @if (request()->routeIs('bo.activity_logs.*') || request()->routeIs('bo.users.*')) fw-bold @endif flex-row border-0"
                    id="navbarDropdownAdmin" data-bs-toggle="dropdown" type="button">
                    {{ __('bo_other_admin') }}
                </button>
                <div class="dropdown-menu m-0 p-1 text-center" aria-labelledby="navbarDropdownAdmin">
                    @can('viewAny', \App\Models\ActivityLog::class)
                        <a class="dropdown-item w-100 text-decoration-none @if (request()->routeIs('bo.activity_logs.*')) active @endif p-2"
                            data-bs-tooltip="tooltip" data-bs-placement="right" href="{{ route('bo.activity_logs.index') }}"
                            title="{{ __('bo_tooltip_list_models', ['count' => count($globalActivities), 'model' => Str::of(trans_choice('models.activity_log', 2))]) }}">
                            {{ Str::of(trans_choice('models.activity_log', 2))->ucfirst() }}
                        </a>
                    @endcan
                    @canAny(['isConceptor', 'viewAny'], \App\Models\User::class)
                        <hr class="dropdown-divider m-0">
                        <a class="dropdown-item w-100 text-decoration-none @if (request()->routeIs('bo.users.*')) active @endif p-2"
                            data-bs-tooltip="tooltip" data-bs-placement="right" href="{{ route('bo.users.index') }}"
                            title="{{ __('bo_tooltip_list_models', ['count' => count($globalUsers), 'model' => Str::of(__('models.user'))->plural()]) }}">
                            {{ Str::of(__('models.user'))->plural()->ucfirst() }}
                        </a>
                    @endcan
                </div>
            </li>
        @endcan
    </ul>
@endauth
