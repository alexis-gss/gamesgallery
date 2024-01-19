<nav id="navbar" class="navbar navbar-expand-xl position-fixed fixed-top bg-body-tertiary shadow-sm">
    <div class="container">
        <a class="navbar-brand"
            href="{{ route('fo.games.index') }}"
            target="_blank"
            data-bs="tooltip"
            data-bs-placement="bottom"
            title="{{ __('bo_other_access_website') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        @auth
        <button class="navbar-toggler collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse"
            aria-expanded="false"
            aria-label="{{ __('bo_other_toggle_navigation') }}">
            <span class="navbar-toggler-icon"></span>
            <i class="navbar-toggler-icon-close fa-solid fa-xmark fa-xl px-1"></i>
        </button>
        @endauth

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Left Side Of Navbar -->
            @include('back.layouts.nav-list')

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Bootstrap themes -->
                <li class="nav-item dropdown border-xl-end">
                    <button class="btn nav-link dropdown-toggle border-0 d-flex flex-row align-items-center justify-content-center w-100 h-100 pe-xl-3"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="d-none d-xl-block fa-solid fa-paint-roller"></i>
                        <span class="d-xl-none">{{ __('bo_other_change_theme') }}</span>
                    </button>
                    <form class="dropdown-menu dropdown-menu-custom dropdown-menu-end text-center p-1"
                        id="theme-selector"
                        action="{{ route('bo.theme.set') }}"
                        method="POST">
                        @push('scripts')
                            <script @if (!empty($nonce)) nonce="{{ $nonce }}" @endif>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const themeSelector = document.getElementById('theme-selector');
                                    if (themeSelector) {
                                        themeSelector.addEventListener('change', function() {
                                            this.submit();
                                        });
                                    }
                                });
                            </script>
                        @endpush
                        @csrf
                        @foreach (\App\Enums\Theme\BootstrapThemeEnum::toArray() as $key => $bootstrapTheme)
                        <input type="radio" class="btn-check" name="theme" id="theme{{ $key }}" value="{{ $bootstrapTheme->value }}">
                        <label class="dropdown-item btn btn-secondary py-2 @if ($bootstrapTheme->value === intval(Cache::get('theme'))) active @endif" for="theme{{ $key }}">
                            {{ Str::of($bootstrapTheme->label)->ucFirst() }}
                        </label>
                        @endforeach
                    </form>
                </li>
                <!-- Lang switchs -->
                <li class="nav-item dropdown @auth border-xl-end @endauth">
                    <button class="btn nav-link dropdown-toggle d-flex align-items-center justify-content-center w-100 h-100 flex-row border-0 px-0 px-xl-3"
                        data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="d-none d-xl-block fa-solid fa-globe"></i>
                        <span class="d-xl-none">{{ __('bo_other_change_locale') }}</span>
                    </button>
                    <form class="dropdown-menu dropdown-menu-custom dropdown-menu-end text-center p-1"
                        id="lang-selector"
                        action="{{ route('bo.lang.set') }}"
                        method="POST">
                        @push('scripts')
                            <script @if (!empty($nonce)) nonce="{{ $nonce }}" @endif>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const langSelector = document.getElementById('lang-selector');
                                    if (langSelector) {
                                        langSelector.addEventListener('change', function() {
                                            this.submit();
                                        });
                                    }
                                });
                            </script>
                        @endpush
                        @csrf
                        @foreach(config('app.locales') as $key => $locale)
                        <input type="radio" class="btn-check" name="lang" id="lang{{ $key }}" value="{{ $locale }}">
                        <label class="dropdown-item btn btn-secondary py-2 @if ($locale === app()->getLocale()) active @endif" for="lang{{ $key }}">
                            {{ Str::of($locale)->upper() }}
                        </label>
                        @endforeach
                    </form>
                </li>
                @auth
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    <button class="btn nav-link dropdown-toggle border-0 d-flex flex-row align-items-center justify-content-center w-100 h-100 ps-xl-3"
                        type="button"
                        id="navbarDropdown"
                        data-bs-toggle="dropdown">
                        <div class="d-flex flex-column align-items-start align-items-xl-end lh-1">
                            <span class="fw-bold">{{ auth('backend')->user()->first_name }}&nbsp;{{ auth('backend')->user()->last_name }}</span>
                            <small class="text-secondary-body">{{ Str::of(auth('backend')->user()->role->label())->ucFirst() }}</small>
                        </div>
                        <div class="profile-picture ms-2 me-1">
                            <img class="w-100 h-100 rounded-circle" src="{{ asset(auth('backend')->user()->picture) }}" alt="{{ auth('backend')->user()->picture_alt }}">
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end text-center m-0 p-1" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item w-100 text-decoration-none p-2"
                            href="{{ route('bo.users.edit', auth('backend')->user()->getKey()) }}"
                            title="{{ __('bo_tooltip_to_edit_profile') }}"
                            data-bs="tooltip"
                            data-bs-placement="left">
                            {{ __('bo_other_edit_profile') }}
                        </a>
                        <hr class="dropdown-divider m-0">
                        <form id="logout-form" action="{{ route('bo.logout') }}" method="POST" class="text-center m-0">
                            @csrf
                            <button class="dropdown-item w-100 text-decoration-none p-2"
                                type="submit"
                                data-bs="tooltip"
                                data-bs-placement="left"
                                title="{{ __('bo_tooltip_to_disconnect') }}">
                                {{ __('bo_other_disconnect') }}
                            </button>
                        </form>
                    </div>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
