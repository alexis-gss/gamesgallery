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
                title="{{ __('bo_tooltip_statistics', ['model' => str(__('models.statistic'))->plural()]) }}">
                {{ str(__('models.statistic'))->plural()->ucfirst() }}
            </a>
        </li>
        @can('viewAny', \App\Models\Game::class)
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('bo.games.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip"
                    data-bs-placement="bottom" href="{{ route('bo.games.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalGames), 'model' => trans_choice('models.game', 2)]) }}">
                    {{ str(trans_choice('models.game', 2))->ucfirst() }}
                </a>
            </li>
        @endcan
        @can('viewAny', \App\Models\Folder::class)
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('bo.folders.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip"
                    data-bs-placement="bottom" href="{{ route('bo.folders.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalFolders), 'model' => str(__('models.folder'))->plural()]) }}">
                    {{ str(__('models.folder'))->plural()->ucfirst() }}
                </a>
            </li>
        @endcan
        @can('viewAny', \App\Models\Tag::class)
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('bo.tags.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip"
                    data-bs-placement="bottom" href="{{ route('bo.tags.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalTags), 'model' => str(__('models.tag'))->plural()]) }}">
                    {{ str(__('models.tag'))->plural()->ucfirst() }}
                </a>
            </li>
        @endcan
        @can('viewAny', \App\Models\Rank::class)
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('bo.ranks.*')) fw-bold @endif text-center" data-bs-tooltip="tooltip"
                    data-bs-placement="bottom" href="{{ route('bo.ranks.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalRanks), 'model' => str(__('models.rank'))->plural()]) }}">
                    {{ str(__('models.rank'))->plural()->ucfirst() }}
                </a>
            </li>
        @endcan
        @canAny(['isConceptor', 'viewAny'], \App\Models\ActivityLog::class)
            <li class="nav-item dropdown">
                <button
                    class="btn nav-link dropdown-toggle d-flex align-items-center justify-content-center w-100 h-100 rounded-0 @if (request()->routeIs('bo.static_pages.*') || request()->routeIs('bo.activity_logs.*') || request()->routeIs('bo.users.*')) fw-bold @endif flex-row border-0"
                    id="navbarDropdownAdmin" data-bs-toggle="dropdown" type="button">
                    {{ __('bo_other_admin') }}
                </button>
                <div class="dropdown-menu m-0 p-1 text-center" aria-labelledby="navbarDropdownAdmin">
                    @can('viewAny', \App\Models\StaticPage::class)
                        <a class="dropdown-item w-100 text-decoration-none @if (request()->routeIs('bo.static_pages.*')) active @endif p-2"
                            data-bs-tooltip="tooltip" data-bs-placement="right" href="{{ route('bo.static_pages.index') }}"
                            title="{{ __('bo_tooltip_list_models', ['count' => count($globalStaticPages), 'model' => trans_choice('models.static_page', 2)]) }}">
                            {{ str(trans_choice('models.static_page', 2))->ucfirst() }}
                        </a>
                    @endcan
                    @can('viewAny', \App\Models\ActivityLog::class)
                        <hr class="dropdown-divider m-0">
                        <a class="dropdown-item w-100 text-decoration-none @if (request()->routeIs('bo.activity_logs.*')) active @endif p-2"
                            data-bs-tooltip="tooltip" data-bs-placement="right" href="{{ route('bo.activity_logs.index') }}"
                            title="{{ __('bo_tooltip_list_models', ['count' => count($globalActivities), 'model' => trans_choice('models.activity_log', 2)]) }}">
                            {{ str(trans_choice('models.activity_log', 2))->ucfirst() }}
                        </a>
                    @endcan
                    @canAny(['isConceptor', 'viewAny'], \App\Models\User::class)
                        <hr class="dropdown-divider m-0">
                        <a class="dropdown-item w-100 text-decoration-none @if (request()->routeIs('bo.users.*')) active @endif p-2"
                            data-bs-tooltip="tooltip" data-bs-placement="right" href="{{ route('bo.users.index') }}"
                            title="{{ __('bo_tooltip_list_models', ['count' => count($globalUsers), 'model' => str(__('models.user'))->plural()]) }}">
                            {{ str(__('models.user'))->plural()->ucfirst() }}
                        </a>
                    @endcan
                </div>
            </li>
        @endcan
    </ul>
@endauth
