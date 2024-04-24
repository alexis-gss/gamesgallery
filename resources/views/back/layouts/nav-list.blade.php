@auth
    <ul class="navbar-nav border-top border-xl-0 mt-xl-0 me-auto mt-2">
        <li class="nav-item">
            <a data-bs-tooltip="tooltip" data-bs-placement="bottom" href="{{ route('bo.home') }}"
                title="{{ __('bo_tooltip_homepage') }}" @class([
                    'nav-link text-center',
                    'fw-bold active' => request()->routeIs('bo.home'),
                ])>{{ __('bo_other_homepage') }}</a>
        </li>
        <li class="nav-item">
            <a data-bs-tooltip="tooltip" data-bs-placement="bottom" href="{{ route('bo.statistics.index') }}"
                title="{{ __('bo_tooltip_statistics', ['model' => str(__('models.statistic'))->plural()]) }}"
                @class([
                    'nav-link text-center',
                    'fw-bold active' => request()->routeIs('bo.statistics.*'),
                ])>{{ str(__('models.statistic'))->plural()->ucfirst() }}</a>
        </li>
        @can('viewAny', \App\Models\Game::class)
            <li class="nav-item">
                <a data-bs-tooltip="tooltip" data-bs-placement="bottom" href="{{ route('bo.games.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalGames), 'model' => trans_choice('models.game', \INF)]) }}"
                    @class([
                        'nav-link text-center',
                        'fw-bold active' => request()->routeIs('bo.games.*'),
                    ])>{{ str(trans_choice('models.game', \INF))->ucfirst() }}</a>
            </li>
        @endcan
        @can('viewAny', \App\Models\Folder::class)
            <li class="nav-item">
                <a data-bs-tooltip="tooltip" data-bs-placement="bottom" href="{{ route('bo.folders.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalFolders), 'model' => str(__('models.folder'))->plural()]) }}"
                    @class([
                        'nav-link text-center',
                        'fw-bold active' => request()->routeIs('bo.folders.*'),
                    ])>{{ str(__('models.folder'))->plural()->ucfirst() }}</a>
            </li>
        @endcan
        @can('viewAny', \App\Models\Tag::class)
            <li class="nav-item">
                <a data-bs-tooltip="tooltip" data-bs-placement="bottom" href="{{ route('bo.tags.index') }}"
                    title="{{ __('bo_tooltip_list_models', ['count' => count($globalTags), 'model' => str(__('models.tag'))->plural()]) }}"
                    @class([
                        'nav-link text-center',
                        'fw-bold active' => request()->routeIs('bo.tags.*'),
                    ])>{{ str(__('models.tag'))->plural()->ucfirst() }}</a>
            </li>
        @endcan
        @canAny(['isConceptor', 'viewAny'], \App\Models\ActivityLog::class)
            @can('viewAny', \App\Models\Rank::class)
                <li class="nav-item">
                    <a data-bs-tooltip="tooltip" data-bs-placement="bottom" href="{{ route('bo.ranks.index') }}"
                        title="{{ __('bo_tooltip_list_models', ['count' => count($globalRanks), 'model' => str(__('models.rank'))->plural()]) }}"
                        @class([
                            'nav-link text-center',
                            'fw-bold active' => request()->routeIs('bo.ranks.*'),
                        ])>{{ str(__('models.rank'))->plural()->ucfirst() }}</a>
                </li>
            @endcan
            <li class="nav-item dropdown">
                <button id="navbarDropdownAdmin" data-bs-toggle="dropdown" type="button"
                    @class([
                        'btn nav-link dropdown-toggle d-flex align-items-center justify-content-center w-100 h-100 rounded-0 flex-row border-0',
                        'fw-bold active' =>
                            request()->routeIs('bo.static_pages.*') ||
                            request()->routeIs('bo.activity_logs.*') ||
                            request()->routeIs('bo.users.*'),
                    ])>{{ __('bo_other_admin') }}</button>
                <div class="dropdown-menu m-0 p-1 text-center" aria-labelledby="navbarDropdownAdmin">
                    @can('viewAny', \App\Models\StaticPage::class)
                        <a data-bs-tooltip="tooltip" data-bs-placement="right" href="{{ route('bo.static_pages.index') }}"
                            title="{{ __('bo_tooltip_list_models', ['count' => count($globalStaticPages), 'model' => trans_choice('models.static_page', \INF)]) }}"
                            @class([
                                'dropdown-item w-100 text-decoration-none p-2',
                                'active' => request()->routeIs('bo.static_pages.*'),
                            ])>{{ str(trans_choice('models.static_page', \INF))->ucfirst() }}</a>
                    @endcan
                    @can('viewAny', \App\Models\ActivityLog::class)
                        <hr class="dropdown-divider m-0">
                        <a data-bs-tooltip="tooltip" data-bs-placement="right" href="{{ route('bo.activity_logs.index') }}"
                            title="{{ __('bo_tooltip_list_models', ['count' => count($globalActivities), 'model' => trans_choice('models.activity_log', \INF)]) }}"
                            @class([
                                'dropdown-item w-100 text-decoration-none p-2',
                                'active' => request()->routeIs('bo.activity_logs.*'),
                            ])>{{ str(trans_choice('models.activity_log', \INF))->ucfirst() }}</a>
                    @endcan
                    @canAny(['isConceptor', 'viewAny'], \App\Models\User::class)
                        <hr class="dropdown-divider m-0">
                        <a data-bs-tooltip="tooltip" data-bs-placement="right" href="{{ route('bo.users.index') }}"
                            title="{{ __('bo_tooltip_list_models', ['count' => count($globalUsers), 'model' => str(__('models.user'))->plural()]) }}"
                            @class([
                                'dropdown-item w-100 text-decoration-none p-2',
                                'active' => request()->routeIs('bo.users.*'),
                            ])>{{ str(__('models.user'))->plural()->ucfirst() }}</a>
                    @endcan
                </div>
            </li>
        @endcan
    </ul>
@endauth
