<nav id="navbar" class="navbar navbar-expand-md navbar-light position-fixed fixed-top bg-light shadow-sm">
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
                <!-- Authentication Links -->
                <li class="nav-item dropdown border-end">
                    <button class="btn nav-link dropdown-toggle border-0 d-flex flex-row align-items-center h-100 pe-3"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-paint-roller"></i>
                    </button>
                    <form class="dropdown-menu dropdown-menu-end text-center"
                        action="{{ route('bo.theme.set') }}"
                        method="POST"
                        onchange="this.submit()">
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
                <li class="nav-item dropdown">
                    <button class="btn nav-link dropdown-toggle border-0 d-flex flex-row align-items-center h-100 ps-3"
                        type="button"
                        id="navbarDropdown"
                        data-bs-toggle="dropdown">
                        <div class="d-flex flex-column align-items-end lh-1">
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                            <small class="text-secondary-body">{{ Auth::user()->role->label() }}</small>
                        </div>
                        <div class="profile-picture ms-2 me-1">
                            <img class="w-100 h-100 rounded-circle" src="{{ asset(Auth::user()->picture) }}" alt="{{ Auth::user()->picture_alt }}">
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end text-center m-0" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item w-100 text-decoration-none p-2"
                            href="{{ route('bo.users.edit', Auth::user()->id) }}"
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
