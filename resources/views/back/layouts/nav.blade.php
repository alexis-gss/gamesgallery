<nav id="navbar" class="navbar navbar-expand-md position-fixed fixed-top bg-body-tertiary shadow-sm">
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
        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        @endauth

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @include('back.layouts.nav-list')

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Bootstrap themes -->
                <li class="nav-item dropdown border-end">
                    <button class="btn nav-link dropdown-toggle border-0 d-flex flex-row align-items-center h-100 pe-3"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-paint-roller"></i>
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
                        <label class="dropdown-item btn btn-secondary @if ($bootstrapTheme->value === intval(Cache::get('theme'))) active @endif" for="theme{{ $key }}">
                            {{ Str::of($bootstrapTheme->label)->ucFirst() }}
                        </label>
                        @endforeach
                    </form>
                </li>
                <!-- Lang switchs -->
                <li class="nav-item dropdown @auth border-end @endauth">
                    <button class="btn nav-link dropdown-toggle d-flex align-items-center h-100 flex-row border-0 px-3"
                        data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="fa-solid fa-globe"></i>
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
                        <label class="dropdown-item btn btn-secondary @if ($locale === app()->getLocale()) active @endif" for="lang{{ $key }}">
                            {{ Str::of($locale)->upper() }}
                        </label>
                        @endforeach
                    </form>
                </li>
                @auth
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    <button class="btn nav-link dropdown-toggle border-0 d-flex flex-row align-items-center h-100 ps-3"
                        type="button"
                        id="navbarDropdown"
                        data-bs-toggle="dropdown">
                        <div class="d-flex flex-column align-items-end lh-1">
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
