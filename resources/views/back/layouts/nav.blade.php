<nav class="navbar navbar-expand-xl position-fixed fixed-top bg-body-tertiary shadow-sm" id="navbar">
    <div class="container">
        <a class="navbar-brand" data-bs-tooltip="tooltip" data-bs-placement="bottom" href="{{ route('fo.games.index') }}"
            title="{{ __('bo_other_access_website') }}" target="_blank">
            {{ config('app.name', 'Laravel') }}
        </a>
        @auth
            <button class="navbar-toggler collapsed" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" type="button"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="{{ __('bo_other_toggle_navigation') }}">
                <span class="navbar-toggler-icon"></span>
                <i class="navbar-toggler-icon-close fa-solid fa-xmark fa-xl px-1"></i>
            </button>
        @endauth

        <div class="navbar-collapse collapse" id="navbarCollapse">
            {{-- Left Side Of Navbar --}}
            @include('back.layouts.nav-list')

            {{-- Right Side Of Navbar --}}
            <ul class="navbar-nav ms-auto">
                {{-- Bootstrap themes --}}
                <li class="nav-item dropdown border-xl-end">
                    <button
                        class="btn nav-link dropdown-toggle d-flex align-items-center justify-content-center w-100 h-100 pe-xl-3 flex-row border-0"
                        data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="d-none d-xl-block fa-solid fa-paint-roller"></i>
                        <span class="d-xl-none">{{ __('bo_other_change_theme') }}</span>
                    </button>
                    <form class="dropdown-menu dropdown-menu-custom dropdown-menu-end p-1 text-center" id="theme-selector"
                        action="{{ route('bo.theme.set') }}" method="POST">
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
                        @use('\App\Enums\Theme\BootstrapThemeEnum', 'BootstrapThemeEnum')
                        @foreach (BootstrapThemeEnum::toArray() as $key => $bootstrapTheme)
                            <input class="btn-check" id="theme{{ $key }}" name="theme" type="radio"
                                value="{{ $bootstrapTheme->value }}">
                            <label for="theme{{ $key }}"
                                @class([
                                    'dropdown-item btn btn-secondary py-2',
                                    'active' => !is_null(cache()->get('theme'))
                                        ? $bootstrapTheme->value === intval(cache()->get('theme'))
                                        : $bootstrapTheme->value === BootstrapThemeEnum::light->value,
                                ])>{{ str($bootstrapTheme->label)->ucFirst() }}</label>
                        @endforeach
                    </form>
                </li>
                {{-- Lang switchs --}}
                <li class="nav-item dropdown @auth border-xl-end @endauth">
                    <button
                        class="btn nav-link dropdown-toggle d-flex align-items-center justify-content-center w-100 h-100 px-xl-3 flex-row border-0 px-0"
                        data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="d-none d-xl-block fa-solid fa-globe"></i>
                        <span class="d-xl-none">{{ __('bo_other_change_locale') }}</span>
                    </button>
                    <form class="dropdown-menu dropdown-menu-custom dropdown-menu-end p-1 text-center" id="lang-selector"
                        action="{{ route('bo.lang.set') }}" method="POST">
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
                        @foreach (config('app.locales') as $key => $locale)
                            <input class="btn-check" id="lang{{ $key }}" name="lang" type="radio"
                                value="{{ $locale }}">
                            <label for="lang{{ $key }}" @class([
                                'dropdown-item btn btn-secondary py-2',
                                'active' => $locale === app()->getLocale(),
                            ])>{{ str($locale)->upper() }}</label>
                        @endforeach
                    </form>
                </li>
                {{-- Authentication Links --}}
                @auth
                    <li class="nav-item dropdown">
                        <button
                            class="btn nav-link dropdown-toggle d-flex align-items-center justify-content-center w-100 h-100 ps-xl-3 flex-row border-0"
                            id="navbarDropdown" data-bs-toggle="dropdown" type="button">
                            <div class="d-flex flex-column align-items-start align-items-xl-end lh-1">
                                <span
                                    class="fw-bold">{{ auth('backend')->user()->first_name }}&nbsp;{{ auth('backend')->user()->last_name }}</span>
                                <small class="text-secondary-body">{{ str(auth('backend')->user()->role->label())->ucFirst() }}</small>
                            </div>
                            <div class="profile-picture me-1 ms-2">
                                <img class="w-100 h-100 rounded-circle" src="{{ asset(auth('backend')->user()->picture) }}"
                                    alt="{{ auth('backend')->user()->picture_alt }}">
                            </div>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end m-0 p-1 text-center" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item w-100 text-decoration-none p-2" data-bs-tooltip="tooltip" data-bs-placement="left"
                                href="{{ route('bo.users.show', auth('backend')->user()->getKey()) }}"
                                title="{{ __('bo_tooltip_to_show_profile') }}">
                                {{ __('bo_other_edit_profile') }}
                            </a>
                            <hr class="dropdown-divider m-0">
                            <form class="m-0 text-center" id="logout-form" action="{{ route('bo.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item w-100 text-decoration-none p-2" data-bs-tooltip="tooltip" data-bs-placement="left"
                                    type="submit" title="{{ __('bo_tooltip_to_disconnect') }}">
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
