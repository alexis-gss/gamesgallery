<nav id="navbar" class="navbar navbar-expand-md position-fixed fixed-top bg-body-tertiary shadow-sm">
    <div class="container">
        <a class="navbar-brand"
            href="{{ route('fo.homepage') }}"
            target="_blank"
            data-bs="tooltip"
            data-bs-placement="bottom"
            title="{{ __('texts.bo.other.access_website') }}">
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
                <li class="nav-item dropdown @auth border-end @endauth">
                    <button class="btn nav-link dropdown-toggle border-0 d-flex flex-row align-items-center h-100 @auth pe-3 @endauth"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-paint-roller"></i>
                    </button>
                    <form class="dropdown-menu dropdown-menu-color dropdown-menu-end text-center"
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
                        @php $theme = intval(Cache::get('theme')); @endphp
                        @foreach (\App\Enums\Theme\BootstrapThemeEnum::toArray() as $key => $bootstrapTheme)
                        <input class="d-none form-check-input"
                            type="radio"
                            name="theme"
                            id="theme{{$key}}"
                            value="{{ $bootstrapTheme->value }}">
                        <label class="dropdown-item w-100 text-decoration-none p-2 @if($bootstrapTheme->value === intval(Cache::get('theme'))) active @endif" for="theme{{$key}}" role="button">
                            {{ $bootstrapTheme->label }}
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
                            <small class="text-secondary-body">{{ auth('backend')->user()->role->label() }}</small>
                        </div>
                        <div class="profile-picture ms-2 me-1">
                            <img class="w-100 h-100 rounded-circle" src="{{ asset(auth('backend')->user()->picture) }}" alt="{{ auth('backend')->user()->picture_alt }}">
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end text-center m-0" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item w-100 text-decoration-none p-2"
                            href="{{ route('bo.users.edit', auth('backend')->user()->getKey()) }}"
                            title="{{ __('texts.bo.tooltip.to_edit_profile') }}"
                            data-bs="tooltip"
                            data-bs-placement="left">
                            {{ __('texts.bo.other.edit_profile') }}
                        </a>
                        <hr class="dropdown-divider m-0">
                        <form id="logout-form" action="{{ route('bo.logout') }}" method="POST" class="text-center m-0">
                            @csrf
                            <button class="dropdown-item w-100 text-decoration-none p-2"
                                type="submit"
                                data-bs="tooltip"
                                data-bs-placement="left"
                                title="{{ __('texts.bo.tooltip.to_disconnect') }}">
                                {{ __('texts.bo.other.disconnect') }}
                            </button>
                        </form>
                    </div>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
